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
        var checkboxes = document.getElementsByName('checkbox-user[]');

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
        } else {
            document.getElementById('admin-filter').style.display = 'inline-block';
            document.getElementById('admin-groupfilter').style.display = 'none';
        }
    }

    </script>
    <?php include_once("../queries/user.php"); ?>
</head>
<body>

<!-- function test_input taken from http://www.w3schools.com/php/php_form_validation.asp -->
<?php
$search = "";
$listnr = 0; // TODO: add page functionality
$status = $groupstatus = array();
$pagetype = "user";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["search"])) {
        $search = test_input($_POST["search"]);
    }

    if (!empty($_POST["pagetype"])) {
        $pagetype = test_input($_POST["pagetype"]);
    }

    if (!empty($_POST["status"])) {
        $status = $_POST["status"];
    }

    if (!empty($_POST["groupstatus"])) {
        $groupstatus = $_POST["groupstatus"];
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
        <form class="admin-actionform"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
              method="post">
        <div class="admin-options">
            <form class="admin-searchform"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                  method="post">
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

                <div class="admin-actions">
                    <h2>Batch Actions: </h2>
                    <input type="radio" name="actions" id="freeze" value="freeze">
                    <label for="freeze">Freeze</label><br>
                    <input type="radio" name="actions" id="ban" value="ban">
                    <label for="ban">Ban</label><br>
                    <input type="radio" name="actions" id="restore" value="restore">
                    <label for="restore">Restore</label><br><br>
                    <input type="submit" value="Confirm">
                </div>
            </div>
            <br>

            <div class="admin-users">
                <h2>Users:</h2>

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
                    $q = search20UsersFromNByStatus($db, $listnr, $search, $status);

                    while($user = $q->fetch(PDO::FETCH_ASSOC)) {
                        $userID = $user['userID'];
                        $username = $user['username'];
                        $role = $user['role'];
                        $bancomment = $user['bancomment'];
                        $thispage = htmlspecialchars($_SERVER['PHP_SELF']);

                        echo("
                            <tr>
                                <td><input type='checkbox'
                                           name='checkbox-user[]'
                                           value='$userID'>
                                </td>
                                <td>$username</td>
                                <td>$role</td>
                                <td>$bancomment</td>
                                <td>
                                    <form class='admin-useraction'
                                          action='$thispage'
                                          method='post'>
                                        <select class='action' name='actions'>
                                            <option value='freeze'>Freeze</option>
                                            <option value='ban'>Ban</option>
                                            <option value='restore'>Restore</option>
                                        </select>
                                        <input type='hidden' name='userID' value='$userID'>
                                        <input type='submit' value='Confirm'>
                                    </form>
                                </td>
                            </tr>
                        ");
                    }
                    ?>
                </table>
            </div>
        </form>
    </div>
</div>
</body>
</html>
