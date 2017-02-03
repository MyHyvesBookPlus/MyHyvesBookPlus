<meta charset="UTF-8">
<meta name="description" content="MyHyvesbook+ is het sociaal medium voor alle coole mensen. Stap nu over van facebook op het gloednieuwe en betere sociaal medium.">
<meta name="keywords" content="MyHyvesbookPlus,Myhyvesbook+,sociaal,media">
<meta name="author" content="MyHyvesbookplus corporation">
<!--Favicon-->
<!-- Desktop Browsers -->
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

<!-- Android: Chrome M39 and up-->
<link rel="manifest" href="manifest.json">
<!-- Android: Chrome M31 and up, ignored if manifest is present-->
<meta name="mobile-web-app-capable" content="yes">
<link rel="icon" sizes="192x192" href="icon-192x192.png">
<!-- iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="My Awesome Web App">

<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon-180x180-precomposed.png">
<link href="apple-touch-icon-152x152-precomposed.png" sizes="152x152" rel="apple-touch-icon">
<link href="apple-touch-icon-144x144-precomposed.png" sizes="144x144" rel="apple-touch-icon">
<link href="apple-touch-icon-120x120-precomposed.png" sizes="120x120" rel="apple-touch-icon">
<link href="apple-touch-icon-114x114-precomposed.png" sizes="114x114" rel="apple-touch-icon">
<link href="apple-touch-icon-76x76-precomposed.png" sizes="76x76" rel="apple-touch-icon">
<link href="apple-touch-icon-72x72-precomposed.png" sizes="72x72" rel="apple-touch-icon">
<link href="apple-touch-icon-60x60-precomposed.png" sizes="60x60" rel="apple-touch-icon">
<link href="apple-touch-icon-57x57-precomposed.png" sizes="57x57" rel="apple-touch-icon">
<link href="apple-touch-icon-precomposed.png" rel="apple-touch-icon">

<!-- Windows 8 and IE 11 -->
<meta name="msapplication-config" content="browserconfig.xml" />

<!-- Windows -->
<meta name="application-name" content="My Awesome Web App" />
<meta name="msapplication-tooltip" content="Get the latest updates!" />
<meta name="msapplication-window" content="width=1024;height=768" />
<meta name="msapplication-navbutton-color" content="#FF3300" />
<meta name="msapplication-starturl" content="./" />

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

if(!isset($_SESSION["userID"])) {
    header("location:login.php?url=" . "$_SERVER[REQUEST_URI]");
} else {
    updateLastActivity();
}
