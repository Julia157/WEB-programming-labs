<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "blogs"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM blogs";
$result = $conn->query($sql);
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
        <?php
            if ($result->num_rows > 0) {
                while ($blog = $result->fetch_assoc()) {
        ?>
            <div class="blog_item">
                <p class="blog_id"><?php echo $blog["Id"] ?></p>
                <p class="blog_title"><?php echo $blog["Title"] ?></p>
                <p class="blog_date"><?php echo $blog["PubDate"] ?></p>
                <div class="blog_links">
                    <a class="blog_link" href="/web/index.php?id=<?php echo $blog["Id"] ?>">
                        <img class="blog_icon" src="./assets/icons/eye.svg">
                    </a>
                    <a class="blog_link" href="/web/edit.php?id=<?php echo $blog["Id"] ?>">
                        <img class="blog_icon" src="./assets/icons/edit.svg">
                    </a>
                </div>
            </div>          

        <?php       }

            }
        ?>
</body>
</html>