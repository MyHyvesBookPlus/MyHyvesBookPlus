<?php

session_start();

if(empty($_POST["grp"])) {
    header('HTTP/1.1 500 Non enough arguments');
}

require_once("../../queries/group_page.php");

echo selectGroupRole($_POST["grp"]);

