<?php

session_start();

if (isset($_SESSION["userID"])) {
    header("Location: profile.php");
} else {
    header("Location: login.php");
}