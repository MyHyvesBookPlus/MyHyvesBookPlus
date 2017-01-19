<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <script type="text/javascript">
    window.onload = function() {
        changeFilter();
    };

    function checkAll(allbox) {
        var checkboxes = document.getElementsByClassName('checkbox-list');

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = allbox.checked;
            }
        }
    }

    function changeFilter() {
        if (document.getElementById('group').checked) {
            document.getElementById('admin-filter').style.display = 'none';
            document.getElementById('admin-groupfilter').style.display = 'inline-block';

            document.getElementById('admin-batchactions').style.display = 'none';
            document.getElementById('admin-groupbatchactions').style.display = 'inline-block';
        } else {
            document.getElementById('admin-filter').style.display = 'inline-block';
            document.getElementById('admin-groupfilter').style.display = 'none';

            document.getElementById('admin-batchactions').style.display = 'inline-block';
            document.getElementById('admin-groupbatchactions').style.display = 'none';
        }
    }

    </script>
    <?php
        include_once("../queries/user.php");
        include_once("../queries/group_page.php");
    ?>
</head>
<body>

<!-- function test_input taken from http://www.w3schools.com/php/php_form_validation.asp -->
<?php
$search = "";
$listnr = 0; // TODO: add page functionality
$status = $groupstatus = array();
$pagetype = "user";

if (isset($_GET["search"])) {
    $search = test_input($_GET["search"]);
}

if (isset($_GET["pagetype"])) {
    $pagetype = test_input($_GET["pagetype"]);
}

if (isset($_GET["status"])) {
    $status = $_GET["status"];
}

if (isset($_GET["groupstatus"])) {
    $groupstatus = $_GET["groupstatus"];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["actions"]) && isset($_POST["userID"])) {
        changeUserStatusByID($db, $_POST["userID"], $_POST["actions"]);
    }

    if (isset($_POST["actions"]) && isset($_POST["groupID"])) {
        changeGroupStatusByID($db, $_POST["groupID"], $_POST["actions"]);
    }

    if (isset($_POST["batchactions"]) && isset($_POST["checkbox-user"])) {
        changeMultipleUserStatusByID($db, $_POST["checkbox-user"], $_POST["batchactions"]);
    }

    if (isset($_POST["groupbatchactions"]) && isset($_POST["checkbox-group"])) {
        changeMultipleGroupStatusByID($db, $_POST["checkbox-group"], $_POST["groupbatchactions"]);
    }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="content">
    <div class="platform admin-panel">
        <div class="admin-title">
            <h1>User Management Panel</h1>
        </div> <br>
        <div class="admin-options">
            <form class="admin-searchform"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                  method="get">
                <div class="admin-searchbar">
                    <h2>Search</h2>
                    <input type="text"
                           name="search"
                           class="admin-searchinput"
                           value="<?php echo $search;?>"> <br>
                    <input type="submit" value="Search">
                </div>

                <div class="admin-filter" id="admin-filter">
                    <h2>Show:</h2>

                    <input type="checkbox" name="status[]" id="normal" value="1"
                           <?php if (in_array("1", $status)) echo "checked";?>>
                    <label for="normal">Normal</label><br>
                    <input type="checkbox" name="status[]" id="frozen" value="2"
                           <?php if (in_array("2", $status)) echo "checked";?>>
                    <label for="frozen">Frozen</label><br>
                    <input type="checkbox" name="status[]" id="banned" value="3"
                           <?php if (in_array("3", $status)) echo "checked";?>>
                    <label for="banned">Banned</label><br>
                    <input type="checkbox" name="status[]" id="admin" value="5"
                           <?php if (in_array("5", $status)) echo "checked";?>>
                    <label for="admin">Admin</label><br>
                    <input type="checkbox" name="status[]" id="unvalidated" value="0"
                           <?php if (in_array("0", $status)) echo "checked";?>>
                    <label for="unvalidated">Unvalidated</label><br>
                    <input type="checkbox" name="status[]" id="owner" value="42"
                           <?php if (in_array("42", $status)) echo "checked";?>>
                    <label for="owner">Owner</label>
                </div>

                <div class="admin-groupfilter" id="admin-groupfilter">
                    <h2>Show:</h2>

                    <input type="checkbox" name="groupstatus[]" id="hidden" value="0"
                           <?php if (in_array("0", $groupstatus)) echo "checked";?>>
                    <label for="hidden">Hidden</label><br>
                    <input type="checkbox" name="groupstatus[]" id="public" value="1"
                           <?php if (in_array("1", $groupstatus)) echo "checked";?>>
                    <label for="public">Public</label><br>
                    <input type="checkbox" name="groupstatus[]" id="membersonly" value="2"
                           <?php if (in_array("2", $groupstatus)) echo "checked";?>>
                    <label for="membersonly">Members-only</label><br>
                </div>

                <div class="admin-filtertype">
                    <h2>Page Type:</h2>
                    <input type="radio" name="pagetype" id="user" value="user"
                           <?php if (isset($pagetype) && $pagetype=="user") echo "checked";?>
                           onchange="changeFilter()">
                    <label for="user">Users</label><br>
                    <input type="radio" name="pagetype" id="group" value="group"
                           <?php if (isset($pagetype) && $pagetype=="group") echo "checked";?>
                           onchange="changeFilter()">
                    <label for="group">Groups</label>
                </div>
            </form>

                <div class="admin-batchactions" id="admin-batchactions">
                    <h2>Batch Actions: </h2>
                    <form class="admin-batchform"
                          id="admin-batchform"
                          action="<?php htmlspecialchars(basename($_SERVER['REQUEST_URI'])) ?>"
                          method="post">
                        <input type="radio" name="batchactions" id="freeze" value="2">
                        <label for="freeze">Freeze</label><br>
                        <input type="radio" name="batchactions" id="ban" value="3">
                        <label for="ban">Ban</label><br>
                        <input type="radio" name="batchactions" id="restore" value="1">
                        <label for="restore">Restore</label><br><br>
                        <input type="submit" value="Confirm">
                    </form>
                </div>

                <div class="admin-groupbatchactions" id="admin-groupbatchactions">
                    <h2>Batch Actions: </h2>
                    <form class="admin-groupbatchform"
                          id="admin-groupbatchform"
                          action="<?php htmlspecialchars(basename($_SERVER['REQUEST_URI'])) ?>"
                          method="post">
                        <input type="radio" name="groupbatchactions" id="hide" value="0">
                        <label for="hide">Hide</label><br>
                        <input type="radio" name="groupbatchactions" id="public" value="1">
                        <label for="public">Public</label><br>
                        <input type="radio" name="groupbatchactions" id="membersonly" value="2">
                        <label for="membersonly">Member</label><br><br>
                        <input type="submit" value="Confirm">
                    </form>
                </div>
            </div>
            <br>

            <div class="admin-users">
                <h2 class="usertitle">Users:</h2>

                <div class="admin-userpage">
                    <input type="submit" name="prev" value="prev">
                    1 / 1
                    <input type="submit" name="next" value="next">
                </div> <br>

                <table class="usertable">
                    <tr>
                        <th class="table-checkbox">
                            <input type="checkbox" name="checkall" onchange="checkAll(this)">
                        </th>
                        <th class="table-username">User</th>
                        <th class="table-status">Status</th>
                        <th class="table-comment">Comment</th>
                        <th class="table-action">Action</th>
                    </tr>

                    <!-- Table construction via php PDO. -->
                    <?php
                    if ($pagetype == 'user') {
                        $q = search20UsersFromNByStatus($db, $listnr, $search, $status);

                        while($user = $q->fetch(PDO::FETCH_ASSOC)) {
                            $userID = $user['userID'];
                            $username = $user['username'];
                            $role = $user['role'];
                            $bancomment = $user['bancomment'];
                            $thispage = htmlspecialchars(basename($_SERVER['REQUEST_URI']));

                            echo("
                            <tr>
                            <td><input type='checkbox'
                            name='checkbox-user[]'
                            class='checkbox-list'
                            value='$userID'
                            form='admin-batchform'>
                            </td>
                            <td>$username</td>
                            <td>$role</td>
                            <td>$bancomment</td>
                            <td>
                            <form class='admin-useraction'
                            action='$thispage'
                            method='post'>
                            <select class='action' name='actions'>
                            <option value='2'>Freeze</option>
                            <option value='3'>Ban</option>
                            <option value='1'>Restore</option>
                            </select>
                            <input type='hidden' name='userID' value='$userID'>
                            <input type='submit' value='Confirm'>
                            </form>
                            </td>
                            </tr>
                            ");
                        }
                    } else {
                        $q = search20GroupsFromNByStatus($db, $listnr, $search, $groupstatus);

                        while ($group = $q->fetch(PDO::FETCH_ASSOC)) {
                            $groupID = $group['groupID'];
                            $name = $group['name'];
                            $role = $group['status'];
                            $description = $group['description'];
                            $thispage = htmlspecialchars(basename($_SERVER['REQUEST_URI']));

                            echo("
                            <tr>
                            <td><input type='checkbox'
                            name='checkbox-group[]'
                            class='checkbox-list'
                            value='$groupID'
                            form='admin-groupbatchform'>
                            </td>
                            <td>$name</td>
                            <td>$role</td>
                            <td>$description</td>
                            <td>
                            <form class='admin-groupaction'
                            action='$thispage'
                            method='post'>
                            <select class='action' name='actions'>
                            <option value='0'>Hide</option>
                            <option value='1'>Public</option>
                            <option value='2'>Members</option>
                            </select>
                            <input type='hidden' name='groupID' value='$groupID'>
                            <input type='submit' value='Confirm'>
                            </form>
                            </td>
                            </tr>
                            ");
                        }
                    }
                    ?>
                </table>
            </div>
        <pre>
            <?php print_r($_POST); ?>
        </pre>
    </div>
</div>
</body>
</html>
