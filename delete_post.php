<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: index.php");
}
$id = $_GET["id"];

//delete your posts
$url = "http://localhost:8080/posts";
$data = array("id" => $id);
$options = array(
    "http" => array(
        "method" => "DELETE",
        "header" => "Content-Type: application/x-www-form-urlencoded",
        "content" => http_build_query($data)
    )
);
$response = file_get_contents($url, false, stream_context_create($options));
header("location: home.php");
