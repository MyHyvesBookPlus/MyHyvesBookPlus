<?php

session_start();

if(empty($_POST["grp"]) or empty($_POST["role"])) {
    header('HTTP/1.1 500 Non enough arguments');
}

if(in_array($_POST["role"], array('request', 'member', 'banned', 'mod', 'admin'))) {
    header('HTTP/1.1 500 Wrong argument given for role');
}

require_once ("../../queries/group_member.php");
require_once ("../../queries/group_page.php");
require_once ("../../queries/group_member.php");

$currentRole = selectGroupRole($_POST["grp"]);
$groupStatus = selectGroupStatus($_POST["grp"]);
echo "role: $currentRole status: $groupStatus ";

if($_POST["role"] == 'request' and $currentRole == 'none') {
    if($groupStatus = 'public') {
        // Add member to public group
        addMember($_POST["grp"], $_SESSION["userID"], 'member');
        echo "ADDED";
    } else if($groupStatus = 'membersonly') {
        // Send request to members only group
        addMember($_POST["grp"], $_SESSION["userID"], 'request');
    } else {
        // Can't invite yourself to hidden groups
        header('HTTP/1.1 500 This group is hidden');
    }
    header('HTTP/1.1 200');
} else if($_POST["role"] == 'none' and $currentRole != 'none') {
    // Remove yourself from a group
    deleteMember($_POST["grp"], $_SESSION["userID"]);
} else {
    echo "failure";
    header('HTTP/1.1 500 Wrong argument given for role');
}