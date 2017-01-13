<header>
    <div id="header-logo">
        <a href="profile.php"><img src="img/top-logo.png" alt="MyHyvesbook+" /></a>
    </div>
    <div id="header-search">
        <form action="search.php" method="get">
            <input name="search" type="text" placeholder="zoek naar van alles" />
            <input type="submit" value="Zoek"/>
        </form>
    </div>
    <div class="right profile-menu">
        <div id="profile-menu-popup">
            <a href="index.php"><span style="color: red;" class="fa fa-sign-out" data-title="Uitloggen"></span></a> |
            <a href="settings.php"><span style="color: blue;" class="fa fa-cog" data-title="Instellingen"></span></a> |
            <a href="profile.php"><span style="color: green;" class="fa fa-user" data-title="Profiel"></span></a>
        </div>
        <div id="profile-hello-popup">
            <div id="hello-loop">
                Hallo
            </div>
            Bart
        </div>
        <img id="own-profile-picture" class="profile-picture" src="data:image/jpeg;base64,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" />
    </div>
    <a href="chat.php"><div class="right fa fa-comments-o" id="open-chat" data-title="Prive chats"></div></a>
</header>