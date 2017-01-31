<?php
$search = "";
$filter = "all";
$user_perpage = $group_perpage = 20;
$user_currentpage = $group_currentpage = 1;

if (isset($_GET['user-pageselect'])) {
    $user_currentpage = test_input($_GET['user-pageselect']);
}

if (isset($_GET['group-pageselect'])) {
    $group_currentpage = test_input($_GET['group-pageselect']);
}

if (isset($_GET['search'])) {
    $search = test_input($_GET['search']);
}

if (isset($_GET['filter'])) {
    $filter = test_input($_GET['filter']);
}

$user_n = ($user_currentpage - 1) * $user_perpage;

$group_n = ($group_currentpage - 1) * $group_perpage;
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
                   id="search-input"
                   name="search"
                   onkeyup="
                           $('#user-pagenumber, #group-pagenumber').prop('value', 1);
                           searchUsers();
                           searchGroups();
                           pageNumber();"
                   placeholder="Zoek"
                   value=<?php echo "$search";?>
            >
            <label for="filter">
                Filter:
            </label>
            <select name="filter" id="search-filter">
                <option value="personal"
                    <?php if ($filter == "personal") echo "selected";?>>
                    Persoonlijk</option>
                <option value="all"
                    <?php if ($filter == "all") echo "selected";?>>
                    Alles</option>
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

        <div id="user-pageselect"></div>

        <ul id='search-users-list' class='nav-list'>
            <script>
            $(document).ready(function(){
                searchUsers();
            });
            </script>
        </ul>
    </div>

    <div class="platform item-box searchright" id="search-group-output">
        <h4>Groepen</h4>

        <div id="group-pageselect"></div>

        <ul id="search-groups-list" class="nav-list">
            <script>
                $(document).ready(function(){
                    searchGroups();
                });
            </script>
        </ul>
    </div>
</div>
