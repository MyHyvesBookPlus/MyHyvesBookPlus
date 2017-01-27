<!DOCTYPE html>
<html>
<head>
    <?php include("../views/head.php"); ?>
    <style>
        @import url("styles/profile.css");
    </style>
</head>
<body>
<?php

include("../queries/group_page.php");

$group = selectGroupByName($_GET["groupname"]);
$members = selectGroupMembers(2);

?>
<script>alert("<?= $members[0] ?>");</script>
<script>alert("<?= $members[1] ?>");</script>
<?php

/*
 * This view adds the main layout over the screen.
 * Header, menu, footer.
 */
include("../views/main.php");

/* Add your view files here. */
include("../views/group.php");

/* This adds the footer. */
include("../views/footer.php");
?>
</body>
</html>
