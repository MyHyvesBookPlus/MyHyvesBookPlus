<?php
$search = "";
$filter = "all";

if (isset($_GET['search'])) {
    $search = test_input($_GET['search']);
}

if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
}
?>

<div class="content">
    <div class="platform">
        <form class="search-form" action="search.php" method="get">
            <label>
                Zoek:
            </label>
            <input type="text"
                   name="search"
                   placeholder="zoek"
                   required
                   value=<?php echo "$search";?>
            >
            <label for="filter">
                Filter:
            </label>
            <select name="filter">
                <option value="all"
                    <?php if ($filter == "all") echo "selected";?>>
                    Alles</option>
                <option value="users"
                    <?php if ($filter == "users") echo "selected";?>>
                    Gebruikers</option>
                <option value="groups"
                    <?php if ($filter == "groups") echo "selected";?>>
                    Groepen</option>
                <option value="friends"
                    <?php if ($filter == "friends") echo "selected";?>>
                    Vrienden</option>
            </select>
            <input type="submit"
                   value="Zoek"
            />
        </form>
    </div>
    <div class="platform item-box searchleft" id="search-friends-output">
        <h4>Gebruikers</h4>
        <ul class='nav-list'>

        <?php
        $q = searchSomeUsers(0, 20, $search);

        while ($user = $q->fetch(PDO::FETCH_ASSOC)) {
            $username = $user['username'];
            $profilepic = $user['profilepicture'];
            $fname = $user['fname'];
            $lname = $user['lname'];

            echo("
                <a href='https://myhyvesbookplus.nl/profile/$username/'>
                    <li class='search-item'>
                        <div class='friend'>
                            <img class='profile-picture' 
                                 src='$profilepic'>
                            $fname $lname ($username)
                        </div>
                    </li>
                </a>
            ");
        }
        ?>

        </ul>
    </div>

    <div class="platform item-box searchright" id="search-group-output">
        <h4>Groepen</h4>
        <ul class="nav-list">

        <?php
        $q = searchSomeGroups(0, 20, $search);

        while ($group = $q->fetch(PDO::FETCH_ASSOC)) {
            $groupname = $group['name'];
            $grouppic = $group['picture'];

            echo("
            <a href='https://myhyvesbookplus.nl/group/$groupname/'>
                <li class='search-item'>
                    <div class='group'>
                        <img class='group-picture' 
                             src='$grouppic'>
                        $groupname
                    </div>
                </li>
            </a>
            ");
        }
        ?>
        </ul>
    </div>
</div>
