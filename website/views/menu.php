<nav class="menu">
    <section id="friends-menu-section">
        <?php

        // Load file.
        require_once("../queries/friendship.php");
        require_once("../queries/user.php");

        // Get confirmed friends of the user and a random non-friend.
        $friends = selectAllFriends($_SESSION["userID"])->fetchAll();
        $randomUser = selectRandomNotFriendUser($_SESSION["userID"])["username"];
        $i = 0;

        if (sizeof($friends) == 0) {
            echo "
                <ul class=\"nav-list\"><li class='friend-item'>
                    <form action='profile.php' method='get'>
                        <button type='submit'
                                name='username'
                                value='$randomUser'>
                            <div class='friend'>
                                Maak nieuwe vrienden :)
                            </div>
                        </button>
                    </form>
                </li><ul class=\"nav-list\">
            ";
        } else {
            echo "
                <h4>
                    Vrienden
                </h4>
                <ul class=\"nav-list\">
            ";

            foreach ($friends as $i => $friend) {
                $username = $friend["username"];
                $extraItem = "";
                $pf = $friend["profilepicture"];

                if ($i >= 5)
                    $extraItem = "extra-menu-items";

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

            if (sizeof($friends) > 5) {
                echo "
                    <li class='more-item' id='more-friends-click'>
                        Meer vrienden..
                    </li> 
                ";
            }
        }
        ?>
    </section>
    <section id="groups-menu-section">
        <?php

        // Load file.
        require_once("../queries/group_member.php");

        // Get all the friends of a user.
        $groups = selectAllGroupsFromUser($_SESSION["userID"]);

        if (sizeof($groups) > 0) {
            echo "
                    <h4>
                        Groepen
                    </h4>
                    <ul class=\"nav-list\">
                ";

            foreach ($groups as $i => $group) {
                // Set default values of a friend.
                $name = $group["name"];
                $extraItem = "";
                $picture = $group["picture"];

                // Change values if needed.
                if ($i > 3)
                    $extraItem = "extra-menu-items";

                echo "
                    <li class='group-item $extraItem'>
                        <form action='group.php' method='get'>
                            <button type='submit'
                                    name='groupname'
                                    value='$name'>
                                <div class='group'>
                                    <img alt='PF' class='group-picture' src='$picture'/>
                                    $name
                                </div>
                            </button>
                        </form>
                    </li>
                ";
            }

            if (sizeof($groups) > 3) {
                echo "
                        <li class='more-item' id='more-groups-click'>
                            Meer groepen..
                        </li> 
                    ";
            }
        }
        ?>
    </section>
    <section>
        <ul>
            <li class="more-item" id="menu-back">
                Terug naar het overzicht
            </li>
        </ul>
    </section>
</nav>
