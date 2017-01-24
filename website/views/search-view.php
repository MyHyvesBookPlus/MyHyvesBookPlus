<?php
$search = "";
$filter = "all";
$user_perpage = $group_perpage = 20;
$user_currentpage = $group_currentpage = 1;

if (isset($_GET['user-pageselect'])) {
    $user_currentpage = $_GET['user-pageselect'];
}

if (isset($_GET['group-pageselect'])) {
    $group_currentpage = $_GET['group-pageselect'];
}

if (isset($_GET['search'])) {
    $search = test_input($_GET['search']);
}

if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
}

$user_n = ($user_currentpage - 1) * $user_perpage;
$user_count = countSomeUsers($search)->fetchColumn();

$group_n = ($group_currentpage - 1) * $group_perpage;
$group_count = countSomeGroups($search)->fetchColumn();
?>

<div class="content">
    <div class="platform">
        <form class="search-form"
              id="search-form"
              action="search.php"
              method="get">
            <label>
                Zoek:
            </label>
            <input type="text"
                   name="search"
                   placeholder="zoek"
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
            <input onclick="document.getElementById('user-pageselect').value = 1;
                            document.getElementById('group-pageselect').value = 1"
                   type="submit"
                   value="Zoek"
            >
        </form>
    </div>
    <div class="platform item-box searchleft" id="search-friends-output">
        <h4>Gebruikers</h4>

        <select class="user-pageselect"
                name="user-pageselect"
                id="user-pageselect"
                form="search-form"
                onchange="this.form.submit()">
            <?php
            for ($i=1; $i <= ceil($user_count / $user_perpage); $i++) {
                if ($user_currentpage == $i) {
                    echo "<option value='$i' selected>$i</option>";
                } else {
                    echo "<option value='$i'>$i</option>";
                }
            }
            ?>
        </select>

        <ul class='nav-list'>

        <?php
        $q = searchSomeUsers($user_n, $user_perpage, $search);

        while ($user = $q->fetch(PDO::FETCH_ASSOC)) {
            $username = $user['username'];
            $profilepic = $user['profilepicture'];
            $fname = $user['fname'];
            $lname = $user['lname'];

            echo("
                <a href='https://myhyvesbookplus.nl/profile?username=$username'>
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

        <select class="group-pageselect"
                name="group-pageselect"
                id="group-pageselect"
                form="search-form"
                onchange="this.form.submit()">
            <?php
            for ($i=1; $i <= ceil($group_count / $group_perpage); $i++) {
                if ($group_currentpage == $i) {
                    echo "<option value='$i' selected>$i</option>";
                } else {
                    echo "<option value='$i'>$i</option>";
                }
            }
            ?>
        </select>

        <ul class="nav-list">

        <?php
        $q = searchSomeGroups($group_n, $user_perpage, $search);

        while ($group = $q->fetch(PDO::FETCH_ASSOC)) {
            $groupname = $group['name'];
            $grouppic = $group['picture'];

            echo("
            <a href='https://myhyvesbookplus.nl/group?groupName=$groupname'>
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
