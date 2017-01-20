<meta charset="utf-8">
<title>MyHyvesbook+</title>
<!-- Add your javascript files here. -->
<script src="/js/jquery.js"></script>
<script src="/js/header.js"></script>
<script src="/js/menu.js"></script>
<style>
    /* Add your css files here. */
    @import url("/styles/main.css");
    @import url("/styles/font-awesome.css");
    @import url("/styles/header.css");
    @import url("/styles/menu.css");
    @import url("/styles/footer.css");
</style>
<?php

require_once ("../queries/checkInput.php");
require_once ("../queries/connect.php");

session_start();

if(!isset($_SESSION["userID"])){
    header("location:login.php");
}