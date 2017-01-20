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
        <div id="profile-menu-popup">
            <a href="/logout"><span style="color: red;" class="fa fa-sign-out" data-title="Uitloggen"></span></a> |
            <a href="/settings"><span style="color: blue;" class="fa fa-cog" data-title="Instellingen"></span></a> |
            <a href="/profile"><span style="color: green;" class="fa fa-user" data-title="Profiel"></span></a>
        </div>
        <div id="profile-hello-popup">
            <div id="hello-loop">
                Hallo
            </div>
            <?=$userinfo["fname"]?>
        </div>
        <img id="own-profile-picture" class="profile-picture" src="<?=$userinfo["profilepicture"]?>"/>
    </div>
    <a href="/chat"><div class="right fa fa-comments-o" id="open-chat" data-title="Prive chats"></div></a>
</header>
