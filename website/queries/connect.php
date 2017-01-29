<?php

$dbconf = simplexml_load_file("/var/mysql_config.xml");
if ($dbconf === FALSE) {
    die("Error parsing XML file");
}
else {
    $GLOBALS["db"] = new PDO("mysql:host=$dbconf->mysql_host;dbname=$dbconf->mysql_database;charset=utf8",
        "$dbconf->mysql_username", "$dbconf->mysql_password")
    or die('Error connecting to mysql server');
}

function prepareQuery(string $query) : PDOStatement {
    return $GLOBALS["db"]->prepare($query);
}