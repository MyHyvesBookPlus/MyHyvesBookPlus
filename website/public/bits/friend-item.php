<?php

session_start();

include_once ("../../queries/friendship.php");

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
    ?>
    <li class='friend-item'>
        <form action='<?= $action ?>' method='<?= $actionType ?>'>
            <button type='submit'
                    name='username'
                    value='<?php
                    if (isset($friend->username)) {
                        echo $friend->username;
                    } else if (isset($friend->content)) {
                        echo $friend->userID;
                    }
                    ?>'>
                <div class='friend'>
                    <img alt='PF' class='profile-picture <?= $friend->onlinestatus ?>' src='<?= $friend->profilepicture ?>'/>
                    <div class='friend-name'>
                        <?= $friend->fullname ?><br/>
                        <span style='color: #666'><?php
                            if (isset($friend->username)) {
                                echo $friend->username;
                            } else if (isset($friend->content)) {
                                echo $friend->content;
                            }
                            ?></span>
                    </div>
                </div>
            </button>
        </form>
        <?php
        if ($friendshipStatus > 1) {
            if ($friendshipStatus == 2) {
                $denyName = "Annuleer";
            } else {
                $denyName = "Weiger";
            }
            ?>
                <div class='notification-options'>
            <?php
            if ($friendshipStatus == 3) {
                ?>
                <button name='accept'
                        onclick="editFriendship('<?= $friend->userID ?>', 'accept')"
                        class='accept-notification'
                        value='1'>
                    <i class='fa fa-check'></i>Accepteer
                </button>
                <?php
            }

            ?>
                <input type='hidden' name='userID' value='' />
                <button name='delete'
                        onclick="editFriendship('<?= $friend->userID ?>', 'delete')"
                        class='deny-notification'
                        value='1'>
                    <i class='fa fa-times'></i> <?= $denyName ?>
                </button>
            </div>
            <?php
        }
        ?>
    </li>
    <?php
}


?>


