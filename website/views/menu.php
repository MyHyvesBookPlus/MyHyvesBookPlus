<nav class="menu">
    <section id="friends-menu-section">
        <h4>
            Vrienden
        </h4>
        <ul id="menu-friends-list" class="nav-list">
        </ul>
        <h4><form action="search.php">
            <input type="hidden"
                   value="friends"
                   name="filter" />
            <button value=""
                    name="search">
                Alle vrienden...
            </button>
        </form></h4>
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