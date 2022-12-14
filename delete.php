<?php
function debug_to_console($data) {
    $output = $data;
    echo "<script>console.warn('Debug: " . $output . "' );</script>";
}

echo 'delete page ';
$id = $_GET["id"];
if ($id) {
    echo $id;
    
    $xml = <<<EOF
    <blog><id>%d</id><title>%s</title><content>%s</content><date>%s</date></blog>
    EOF;

    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = 0;
    $dom->formatOutput = 1;

    $blogs = simplexml_load_file("list.xml");
    debug_to_console(json_encode($blogs));

    $newBlogs = new SimpleXMLElement("<data></data>");
    $dom->loadXML($newBlogs->asXML());
    foreach($blogs as $blog)
    {
        if ($blog->id == $id) {
            echo " -> found";
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
else
{
    header("Location: list.php");
}

error_reporting(E_ALL);
ini_set('display_errors', '1');
?>