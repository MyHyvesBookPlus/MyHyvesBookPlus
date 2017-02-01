<?php
if ($option == "user") {
    echo "<select class=\"user-pageselect\"
    name=\"user-pageselect\"
    id='user-pagenumber'
    form=\"search-form\"
    onchange=\"pageNumber(); searchUsers();\">";

    for ($i=1; $i <= ceil($user_count / $user_perpage); $i++) {
        if ($user_currentpage == $i) {
            echo "<option value='$i' selected>$i</option>";
        } else {
            echo "<option value='$i'>$i</option>";
        }
    }

    echo "</select>";
} else {
    echo "<select class=\"group-pageselect\"
    name=\"group-pageselect\"
    id='group-pagenumber'
    form=\"search-form\"
    onchange=\"pageNumber(); searchGroups();\">";

    for ($i=1; $i <= ceil($group_count / $group_perpage); $i++) {
        if ($group_currentpage == $i) {
            echo "<option value='$i' selected>$i</option>";
        } else {
            echo "<option value='$i'>$i</option>";
        }
    }

    echo "</select>";
}

?>
