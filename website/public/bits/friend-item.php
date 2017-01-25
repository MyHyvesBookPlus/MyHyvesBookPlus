<?php

session_start();

include_once ("../../queries/friendship.php");

if (isset($_POST["limit"])) {
    $limit = $_POST["limit"];
} else {
    $limit = 5;
}

if (isset($_POST["action"])) {
    $action = $_POST["action"];
} else {
    $action = "profile.php";
}

if (isset($_POST["actionType"])) {
    $actionType = $_POST["actionType"];
} else {
    $actionType = "GET";
}

$friends = json_decode($_POST["friends"]);

foreach($friends as $i => $friend) {
    $friendshipStatus = getFriendshipStatus($friend->userID);

    if ($limit != 0 && $i >= $limit)
        $extra = "extra-friend-item";
    else
        $extra = "";
    ?>
    <li class='friend-item <?= $extra ?>'>
        <form action='<?= $action ?>' method='<?= $actionType ?>'>
            <button type='submit'
                    name='username'
                    value='<?= $friend->username ?>'>
                <div class='friend'>
                    <img alt='PF' class='profile-picture' src='<?= $friend->profilepicture ?>'/>
                    <div class='friend-name'>
                        <?= $friend->fullname ?><br/>
                        <span style='color: #666'><?= $friend->username ?></span>
                    </div>
                </div>
            </button>
        </form>
        <?php
        if ($friendshipStatus > 1) {
            ?>
            <div class='notification-options'>
                <form action='API/edit_friendship.php' method='post'>
                    <input type='hidden' name='userID' value='<?= $friend->userID ?>' />
                    <button type='submit'
                            name='delete'
                            class='deny-notification'
                            value='1'>
                        <i class='fa fa-times'></i>
                    </button>
            <?php
            if ($friendshipStatus == 3) {
                ?>
                    <button type='submit'
                            name='accept'
                            class='accept-notification'
                            value='1'>
                        <i class='fa fa-check'></i>
                    </button>
                <?php
            }
            ?>
                <form>
            </div>
            <?php
        }
        ?>
    </li>
    <?php
}

if (sizeof($friends) > $limit) {
    ?>
    <li class='more-item'>
        Meer vrienden...
    </li>
    <?php
}

?>


