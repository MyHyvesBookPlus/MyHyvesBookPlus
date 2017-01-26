<?php

if(empty($_POST["usr"])) {
    header('HTTP/1.1 500 Non enough arguments');
}

require_once ("../../queries/user.php");
require_once ("../../queries/nicetime.php");

$posts = selectAllUserPosts($_POST["usr"]);

if(!$posts) {
    header('HTTP/1.1 500 Query failed');
}

$results = $posts->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < sizeof($results); $i++) {
    $results[$i]["nicetime"] = nicetime($results[$i]["creationdate"]);
}

//$results[0]["niceTime"] = nicetime($results[0]["creationdate"]);

echo json_encode($results);