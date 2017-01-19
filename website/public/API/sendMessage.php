<?php

include_once("../../queries/private_message.php");

if (isset($_POST["destination"]) &&
    isset($_POST["content"])) {

    if (sendMessage($_POST["destination"], $_POST["content"])) {
        echo $_POST["content"] . " is naar " . $_POST["destination"] . " gestuurd";
    } else {
        echo "YOU FAILED!!!";
    }

} else {
    echo "maybe dont try to hax the system?";
}