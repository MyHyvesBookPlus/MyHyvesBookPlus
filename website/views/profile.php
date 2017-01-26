<div class="content">
    <div class="profile-box platform">
        <img class="left profile-picture" src="<?php echo $user["profilepicture"] ?>">

        <div class="friend-button-container">

        </div>

        <h1 class="profile-username"><?= $user["fname"]?> <?=$user["lname"]?></h1>
        <h5 class="profile-username"><?=$user["username"]?></h5>
        <p><?=$user["bio"]?></p>
    </div>

    <div class="item-box left platform">
        <h2>Vrienden</h2>
        <p>
            <?php
                while($friend = $profile_friends->fetch()) {
                    echo "<a href='profile.php?username=${friend["username"]}' data-title='${friend["username"]}'><img class='profile-picture' src='${friend["profilepicture"]}' alt='${friend["username"]}'s profielfoto></a>";
                }


                if($profile_friends->rowCount() === 0) {
                    echo "<p>Deze gebruiker heeft nog geen vrienden gemaakt.</p>";
                }
            ?>
        </p>
    </div>

    <div class="item-box right platform">
        <h2>Groepen</h2>
        <p>
            <?php
                while($group = $profile_groups->fetch()) {
                    echo "<a href='/group/${group["name"]}/' data-title='${group["name"]}'><img class='group-picture' src='${group["picture"]}' alt='${group["name"]}s logo'></a>";
                }

                if($profile_groups->rowCount() === 0) {
                    echo "<p>Deze gebruiker is nog geen lid van een groep.</p>";
                }
            ?>
        </p>
    </div>

    <div class="posts">
<!--        --><?php
//            if ($_SESSION["userID"] === $userID) {
//         ?>
<!--                <div class="post platform">-->
<!--                    <form>-->
<!--                        <input type="text" class="newpost" placeholder="Titel">-->
<!--                        <textarea class="newpost" placeholder="Schrijf een berichtje..."></textarea>-->
<!--                        <input type="submit" value="Plaats!">-->
<!--                    </form>-->
<!--                </div>-->
<!--        --><?php
//            }
//
//            while($post = $posts->fetch()) {
//                $nicetime = nicetime($post["creationdate"]);
//                echo "
//                    <div class='post platform'>
//                        <h2>${post["title"]}</h2>
//                        <p>${post["content"]}</p>
//                        <p class=\"subscript\">${nicetime} geplaatst.</p>
//                    </div>
//                ";
//            }
//        ?>
    </div>
</div>