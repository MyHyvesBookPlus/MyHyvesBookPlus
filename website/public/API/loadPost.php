<?php

require_once("../../queries/connect.php");
require_once("../../queries/post.php");
require_once("../../queries/checkInput.php");
require_once("../../queries/nicetime.php");

if(isset($_GET['postID'])) {
    include("../../views/post-view.php");
} else {
    echo "Failed to load";
}