<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/user.php");
require_once ("../../queries/group_page.php");
require_once ("../../queries/friendship.php");
require_once ("../../queries/group_member.php");

if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'banned') {$user_perpage = $group_perpage = 20;

    $user_currentpage = $group_currentpage = 1;
    if (isset($_POST['user-pageselect'])) {
        $user_currentpage = test_input($_POST['user-pageselect']);
    }
    if (isset($_POST['group-pageselect'])) {
        $group_currentpage = test_input($_POST['group-pageselect']);
    }

    $user_n = $user_currentpage * $user_perpage - $user_perpage;
    $group_n = $group_currentpage * $group_perpage - $group_perpage;

    $search = "";
    if (isset($_POST['search'])) {
        $search = test_input($_POST['search']);
    }

    $filter = "all";
    if (isset($_POST['filter'])) {
        $filter = test_input($_POST['filter']);
    }

    if ($filter == "all") {
        $user_count = countSomeUsers($search)->fetchColumn();
        $group_count = countSomeGroups($search)->fetchColumn();
    } else {
        $user_count = countSomeFriends($search);
        $group_count = countSomeOwnGroups($search);
    }


    $option = "user";
    if (isset($_POST['option'])) {
        $option = test_input($_POST['option']);
    }

    include ("../../views/searchPageNumber.php");
} else {
    header('HTTP/1.0 403 Forbidden');
}
