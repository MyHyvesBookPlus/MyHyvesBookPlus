<nav class="menu">
    <section id="friends-menu-section">
        <h4>
            Vrienden
        </h4>
        <ul class="nav-list">
            <?php

            // Load file.
            include_once("../queries/friendship.php");

            // Get all the friends of a user.
            $friends = selectAllFriends($_SESSION["userID"]);
            $i = 0;

            // Print all the users.
            while($friend = $friends->fetch(PDO::FETCH_ASSOC)) {
                $i ++;

                // Set default values of a friend.
                $username = $friend["username"];
                $extraItem = "";
                $pf = "img/notbad.jpg";

                // Change values if needed.
                if (!empty($friend["profilepicture"]))
                    $pf = $friend["profilepicture"];

                if ($i > 1)
                    $extraItem = "extra-menu-items";

                // Echo the friend.
                echo "
                    <li class='friend-item $extraItem'>
                        <form action='profile.php' method='get'>
                            <button type='submit'
                                    name='username'
                                    value='$username'>
                                <div class='friend'>
                                    <img alt='PF' class='profile-picture' src='$pf'/>
                                    $username
                                </div>
                            </button>
                        </form>
                    </li>
                ";
            }
            if ($i > 1) {
                $i -= 1;
                echo "
            <li class='more-item' id='more-friends-click'>
                En nog $i anderen...
            </li>";
            }
            ?>
        </ul>
    </section>
    <section id="groups-menu-section">
        <h4>
            Groepen
        </h4>
        <ul class="nav-list">
            <?php

            // Load file.
            include_once("../queries/group_member.php");

            // Get all the friends of a user.
            $groups = selectAllGroupsFromUser($_SESSION["userID"]);
            $i = 0;

            // Print all the users.
            while($group = $groups->fetch(PDO::FETCH_ASSOC)) {
                $i ++;

                // Set default values of a friend.
                $name = $group["name"];
                $extraItem = "";
                $picture = "img/notbad.jpg";

                // Change values if needed.
                if (!empty($group["picture"]))
                    $picture = $group["picture"];

                if ($i > 3)
                    $extraItem = "extra-menu-items";

                // Echo the friend.
                echo "
                    <a href='#' class='$extraItem'>
                        <li class='group-item'>
                            <div class='group'>
                                <img alt='PF' class='group-picture' src='$picture'/>
                                $name
                            </div>
                        </li>
                    </a>
                ";
            }
            if ($i > 3) {
                $i -= 3;
                echo "
                    <li class='more-item' id='more-groups-click'>
                        En nog $i andere...
                    </li>
                ";
            }
            ?>
        </ul>
    </section>
    <section>
        <ul>
            <li class="more-item" id="menu-back">
                Ga terug
            </li>
        </ul>
    </section>
</nav>
