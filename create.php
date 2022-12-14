<?php
function debug_to_console($data) {
    $output = $data;
    echo "<script>console.warn('Debug: " . $output . "' );</script>";
}

$errors = [];
$title = '';
$content = '';
$date = '';

$file = simplexml_load_file("list.xml");

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
    if ($date < date("Y-m-d")) {
        array_push($errors, "Select actual date!");
    }

    if (count($errors) == 0) {
        $xml = <<<EOF
        <blog><id>%d</id><title>%s</title><content>%s</content><date>%s</date></blog>
        EOF;

        // new DOMDocument
        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = 0;
        $dom->formatOutput = 1;

        $file = simplexml_load_file("list.xml");
        debug_to_console(count($file));
        $dom->loadXML($file->asXML());
        debug_to_console(json_encode($file));
        if (end(end($file))) {
            $id = end(end($file))->id + 1;
        } else {
            $id = 1;
        }
        $xmlSnippet = sprintf($xml, $id, $title,  $content, $date);

        $fragment = $dom->createDocumentFragment();
        $fragment->appendXML($xmlSnippet);

        $dom->documentElement->appendChild($fragment);
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
    <title>Create Blog</title>
</head>
<body>
    <div id="form_wrapper">
        <h2 id="form_title">Create Blog</h2>
        <a class="circle back" href="/web/list.php"></a>
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
        <button type="submit">Create</button>
        </form>
    </div>
</body>
</html>