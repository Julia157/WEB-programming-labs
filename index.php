<?php
function debug_to_console($data) {
    $output = $data;
    echo "<script>console.log('Log: " . $output . "' );</script>";
}

$id = $_GET['id'];
$blogs = simplexml_load_file("list.xml");
$result=null;

foreach($blogs as $blog)
{
    if ($blog->id == $id)
    {
        $result = $blog;
        break;
    }
}

debug_to_console($id);
debug_to_console(json_encode($result));
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/index.css" />
    <title>Blog</title>
</head>
<body>
    <div id="blog_wrapper">
        <?php if(!$result): ?>
            <h2 class="not_found">Blog is not found! Could be deleted</h2>
            <a class="circle back" href="/web/list.php"></a>
        <?php else: ?>
            <h2 class="blog_title"><?php echo $result->title ?></h2>
            <p class="blog_content"><?php echo $result->content ?></p>
            <span class="blog_date"><?php echo $result->date ?></span>
            <a class="circle back" href="/web/list.php"></a>
            <a class="circle edit" href="/web/edit.php?id=<?php echo $result->id ?>">
                <img class="edit_icon" src="./assets/icons/edit.svg">
            </a>
            <a class="circle delete" href="/web/delete.php?id=<?php echo $result->id ?>">
                <img class="blog_icon" src="./assets/icons/delete.svg">
            </a>
        <?php endif; ?>
    </div>
</body>
</html>