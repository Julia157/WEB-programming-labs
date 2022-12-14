<?php
function debug_to_console($data) {
    $output = $data;
    echo "<script>console.warn('Debug: " . $output . "' );</script>";
}

$errors = [];
$title = '';
$content = '';
$date = '';
$id = $_GET["id"];
$result = null;
$blogs = simplexml_load_file("list.xml");

foreach($blogs as $blog)
{
    if ($blog->id == $id)
    {
        $result = $blog;
        $title = $blog->title;
        $content = $blog->content;
        $date = $blog->date;
        break;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $date = trim($_POST["date"]);

    if (strlen($title) <= 0) {
        array_push($errors, "Fill title!");
    }
    if (strlen($content) <= 0) {
        array_push($errors, "Fill content!");
    }
    if (strlen($date) <= 0) {
        array_push($errors, "Fill date!");
    }

    if (count($errors) == 0) {
        $xml = <<<EOF
        <blog><id>%d</id><title>%s</title><content>%s</content><date>%s</date></blog>
        EOF;

        $newBlogs = new SimpleXMLElement("<data></data>");
        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = 0;
        $dom->formatOutput = 1;
        $dom->loadXML($newBlogs->asXML());
        foreach($blogs as $blog)
        {
            if ($blog->id == $result->id) {
                debug_to_console($title);
                debug_to_console($content);
                debug_to_console($date);
                $xmlSnippet = sprintf($xml, $id, $title, $content, $date);
    
                $fragment = $dom->createDocumentFragment();
                $fragment->appendXML($xmlSnippet);
    
                $dom->documentElement->appendChild($fragment);
            } else {
                $xmlSnippet = sprintf($xml, $blog->id, $blog->title,  $blog->content, $blog->date);
    
                $fragment = $dom->createDocumentFragment();
                $fragment->appendXML($xmlSnippet);
    
                $dom->documentElement->appendChild($fragment);
            }
        }

        debug_to_console(json_encode($newBlogs));
        $dom->save("list.xml");
        header("Location: index.php?id=" . $id);
    }
}

error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/create.css" />
    <title>Edit Blog</title>
</head>
<body>
    <div id="form_wrapper">
        <a class="circle back" href="/web/list.php"></a>
        <?php if(!$result): ?>
            <h2 class="not_found">Blog is not found! Could be deleted</h2>
            <a class="circle back" href="/web/list.php"></a>
        <?php else: ?>
            <h2 id="form_title">Edit Blog</h2>
            <?php
            if(count($errors)){
            echo "<ul id='errors_list'>";
            foreach($errors as $error){
                echo "<li>$error</li>";
            }
            echo "</ul>";
            }
            ?>
            <form id="create_form" method="POST">
            <input required type="text" class="create_input" name="title" value="<?php echo $title;?>" placeholder="Blog title"/>
            <input required type="text" class="create_input" name="content" value="<?php echo $content;?>" placeholder="Blog content" />
            <input required type="date" class="create_input" name="date" value="<?php echo $date;?>" placeholder="Blog publication date"/>
            <button type="submit">Edit</button>
        <?php endif; ?>
        </form>
    </div>
</body>
</html>