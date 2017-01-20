<?php
include_once ("../queries/header.php");

$userinfo = getHeaderInfo();
?>
<header>
    <div id="header-logo">
        <a href="profile.php"><img src="/img/top-logo.png" alt="MyHyvesbook+" /></a>
    </div>
    <div id="header-search">
        <form action="/search" method="get">
            <input name="search"
                   type="text"
                   placeholder="Zoek naar wat je wil"
                   required
            />
            <input type="submit"
                   value="Zoek"/>
        </form>
    </div>
    <div class="right profile-menu">
        <div id="profile-hello-popup">
            <div id="hello-loop">
                Hallo
            </div>
            <?=$userinfo["fname"]?>
        </div>
        <img id="own-profile-picture" class="profile-picture" src="<?=$userinfo["profilepicture"]?>"/>
    </div>
</header>
<?php include("notification-center.php"); ?>

