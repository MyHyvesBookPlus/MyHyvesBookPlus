<nav class="menu" id="notification-center">
    <section id="quick-links">
        <a href="chat.php" data-title="Prive chats"><i class="fa fa-comments-o"></i></a>
        <a href="settings.php" data-title="Instellingen"><i class="fa fa-cog"></i></a>
        <a href="profile.php" data-title="Profiel"><i class="fa fa-user"></i></a>
        <?php
        include_once ("../queries/user.php");

        // auth
        $role = getRoleByID($_SESSION['userID']);

        if ($role == 'admin' OR $role == 'owner') {
            echo "<a href=\"admin.php\" data-title=\"Admin\"><i class=\"fa fa-lock\"></i></a>";
            echo "<style>@import url('styles/adminbutton.css'); </style>";
        }
        ?>
        <a href="logout.php" data-title="Admin"><i class="fa fa-sign-out"></i></a>
    </section>
    <section id="friend-request-section">
        <h4>
            Verzoeken
        </h4>
        <ul class="nav-list" id="friend-requests-list">

        </ul>
    </section>
    <section id="unread-messages-section">
        <h4>
            Nieuwe berichten
        </h4>
        <ul class="nav-list" id="unread-chat-list">

        </ul>
    </section>
</nav>