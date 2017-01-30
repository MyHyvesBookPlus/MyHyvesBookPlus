<?php

if(empty($_POST["usr"]) and empty($_POST["grp"])) {
    header('HTTP/1.1 500 Non enough arguments');
}

require_once ("../../queries/post.php");
require_once ("../../queries/nicetime.php");

if(empty($_POST["usr"])) {
    $posts = selectAllPosts(0, $_POST["grp"]);
} else {
    $posts = selectAllPosts($_POST["usr"], 0);
}

if(!$posts) {
    header('HTTP/1.1 500 Query failed');
}

$results = $posts->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < sizeof($results); $i++) {
    $results[$i]["nicetime"] = nicetime($results[$i]["creationdate"]);
}

echo json_encode($results);