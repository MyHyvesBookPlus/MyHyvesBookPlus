<meta charset="UTF-8">
<meta name="description" content="MyHyvesbook+ is het sociaal medium voor alle coole mensen. Stap nu over van facebook op het gloednieuwe en betere sociaal medium.">
<meta name="keywords" content="MyHyvesbookPlus,Myhyvesbook+,sociaal,media">
<meta name="author" content="MyHyvesbookplus corporation">
<title>MyHyvesbook+</title>
<!-- Add your javascript files here. -->
<script src="js/jquery.js"></script>
<script src="js/main.js"></script>
<script src="js/header.js"></script>
<script src="js/menu.js"></script>
<style>
    /* Add your css files here. */
    @import url("styles/main.css");
    @import url("styles/font-awesome.css");
    @import url("styles/header.css");
    @import url("styles/menu.css");
    @import url("styles/footer.css");

    @import url("styles/mobilefriendly.css") screen and (orientation: portrait);
</style>
<?php

require_once ("../queries/checkInput.php");
require_once ("../queries/connect.php");
require_once ("../queries/user.php");

session_start();

$_SESSION["userID"] = 11;
if(!isset($_SESSION["userID"])) {
    header("location:login.php?url=" . "$_SERVER[REQUEST_URI]");
} else {
    updateLastActivity();
}
