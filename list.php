<?php
$dom = new DOMDocument;
$dom->preserveWhiteSpace = 0;
$dom->formatOutput = 1;

$blogs = simplexml_load_file("list.xml");
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/list.css" />
    <title>Blog list</title>
</head>
<body>
    <div id="list_wrapper">
        <h2 id="list_title">Blog List</h2>
        <a class="create plus" href="/web/create.php"></a>
        <?php foreach($blogs as $blog):?>
            <div class="blog_item">
                <p class="blog_id"><?php echo $blog->id ?></p>
                <p class="blog_title"><?php echo $blog->title ?></p>
                <p class="blog_date"><?php echo $blog->date ?></p>
                    <div class="blog_links">
                        <a class="blog_link" href="/web/index.php?id=<?php echo $blog->id ?>">
                            <img class="blog_icon" src="./assets/icons/eye.svg">
                        </a>
                        <a class="blog_link" href="/web/edit.php?id=<?php echo $blog->id ?>">
                            <img class="blog_icon" src="./assets/icons/edit.svg">
                        </a>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
</body>
</html>