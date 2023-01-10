<?php
function debug_to_console($data) {
    $output = $data;
    echo "<script>console.warn('Debug: " . $output . "' );</script>";
}

echo 'delete page ';
$id = $_GET["id"];
if ($id) {
    echo $id;
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "blogs"; 
    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "DELETE FROM blogs WHERE Id=$id";
    $result = $conn->query($sql);
    header("Location: index.php?id=" . $id);
}
else
{
    header("Location: list.php");
}

error_reporting(E_ALL);
ini_set('display_errors', '1');
?>