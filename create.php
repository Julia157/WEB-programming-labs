<?php
function debug_to_console($data) {
    $output = $data;
    echo "<script>console.warn('Debug: " . $output . "' );</script>";
}

$errors = [];
$title = "";
$content = "";
$date = "";

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
        $servername = "localhost";
        $username = "root"; 
        $password = ""; 
        $dbname = "blogs"; 
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO `blogs`(`Title`, `Content`, `PubDate`) VALUES ('$title','$content','$date')";
        $result = $conn->query($sql);

        if ($result == FALSE) {
            echo "Error:". $sql . "<br>". $conn->error;
        }
        $last_id = $conn->insert_id;
        $conn->close(); 
        header("Location: index.php?id=" . $last_id);
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