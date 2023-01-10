<?php
function debug_to_console($data) {
    $output = $data;
    echo "<script>console.log('Log: " . $output . "' );</script>";
}

$id = $_GET['id'];
$result=null;
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "blogs"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM blogs WHERE id=$id";
$result = $conn->query($sql);
if ($result == TRUE) {
    $row = $result->fetch_assoc();
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
    <link rel="stylesheet" href="./styles/index.css" />
    <title>Blog</title>
</head>
<body>
    <div id="blog_wrapper">
        <?php if(!$row): ?>
            <h2 class="not_found">Blog is not found! Could be deleted</h2>
            <a class="circle back" href="/web/list.php"></a>
        <?php elseif ($row): ?>
            <h2 class="blog_title"><?php echo $row["Title"] ?></h2>
            <p class="blog_content"><?php echo $row["Content"] ?></p>
            <span class="blog_date"><?php echo $row["PubDate"] ?></span>
            <a class="circle back" href="/web/list.php"></a>
            <a class="circle edit" href="/web/edit.php?id=<?php echo $row["Id"] ?>">
                <img class="edit_icon" src="./assets/icons/edit.svg">
            </a>
            <a class="circle delete" href="/web/delete.php?id=<?php echo $row["Id"] ?>">
                <img class="blog_icon" src="./assets/icons/delete.svg">
            </a>
        <?php endif; ?>
    </div>
</body>
</html>