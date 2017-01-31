<!DOCTYPE html>
<html>
<head>
    <?php
    require_once ("../queries/user.php");
    require_once ("../queries/group_page.php");
    require_once ("../views/head.php"); ?>
    <style>
        @import url("styles/adminpanel.css");
    </style>
<script src="js/admin.js" charset="utf-8"></script>
</head>
<body>
<?php
/*
 * This view adds the main layout over the screen.
 * Header and menu.
 */
include_once ("../queries/user.php");

// auth
$role = getRoleByID($_SESSION['userID']);

if ($role != 'admin' AND $role != 'owner') {
    header("location:profile.php");
}

include("../views/main.php");

/* Add your view files here. */
include("../views/adminpanel.php");

/* This adds the footer. */
include("../views/footer.php");
?>
</body>
</html>
