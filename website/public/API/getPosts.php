<?php

if(!isset($_POST["offset"]) or !isset($_POST["limit"])) {
    header('HTTP/1.1 500 Not enough arguments');
}
if(!isset($_POST["usr"]) and !isset($_POST["grp"])) {
    header('HTTP/1.1 500 Not enough arguments');
}

require_once ("../../queries/post.php");
require_once ("../../queries/nicetime.php");

if(empty($_POST["usr"])) {
    $posts = selectSomePosts(0, $_POST["grp"], $_POST["offset"], $_POST["limit"]);
} else {
    $posts = selectSomePosts($_POST["usr"], 0, $_POST["offset"], $_POST["limit"]);
}

if(!$posts) {
    echo false;
} else {
    $results = $posts->fetchAll(PDO::FETCH_ASSOC);

    for($i = 0; $i < sizeof($results); $i++) {
        $results[$i]["nicetime"] = nicetime($results[$i]["creationdate"]);
    }

    echo json_encode($results);
}

