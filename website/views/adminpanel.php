<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <script type="text/javascript">
    function checkAll(allbox) {
        var checkboxes = document.getElementsByName('check1');

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = allbox.checked;
            }
        }
    }
    </script>
</head>
<body>

<!-- function test_input taken from http://www.w3schools.com/php/php_form_validation.asp -->
<?php
$search = $pagetype = "";
$status = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = test_input($_POST["search"]);

    if (!empty($_POST["pagetype"])) {
        $pagetype = test_input($_POST["pagetype"]);
    }

    if (!empty($_POST["status"])) {
        $status = $_POST["status"];
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
                <div class="admin-filter">
                    <h2>Show:</h2>
                    <input type="checkbox" name="status[]" id="normal" value="normal"
                           <?php if (in_array("normal", $status)) echo "checked";?>>
                    <label for="normal">Normal</label><br>
                    <input type="checkbox" name="status[]" id="frozen" value="frozen"
                           <?php if (in_array("frozen", $status)) echo "checked";?>>
                    <label for="frozen">Frozen</label><br>
                    <input type="checkbox" name="status[]" id="banned" value="banned"
                           <?php if (in_array("banned", $status)) echo "checked";?>>
                    <label for="banned">Banned</label><br>
                    <input type="checkbox" name="status[]" id="admin" value="admin"
                           <?php if (in_array("admin", $status)) echo "checked";?>>
                    <label for="admin">Admin</label><br>
                    <input type="checkbox" name="status[]" id="unvalidated" value="unvalidated"
                           <?php if (in_array("unvalidated", $status)) echo "checked";?>>
                    <label for="unvalidated">Unvalidated</label>
                </div>
                <div class="admin-filtertype">
                    <h2>Page Type:</h2>
                    <input type="radio" name="pagetype" id="user" value="user"
                           <?php if (isset($pagetype) && $pagetype=="user") echo "checked";?>>
                    <label for="user">Users</label><br>
                    <input type="radio" name="pagetype" id="group" value="group"
                           <?php if (isset($pagetype) && $pagetype=="group") echo "checked";?>>
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
                    <tr>
                        <td><input type="checkbox" name="check1"></td>
                        <td>John Smith</td>
                        <td>Banned</td>
                        <td>unregulated time travel</td>
                        <td>
                            <form class="admin-useraction"
                                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                                  method="post">
                                <select class="action" name="actions">
                                    <option value="freeze">Freeze</option>
                                    <option value="ban">Ban</option>
                                    <option value="restore">Restore</option>
                                </select>
                                <input type="submit" value="Confirm">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="check1"></td>
                        <td>poey jokeaim</td>
                        <td>Banned</td>
                        <td>l33t h4xx</td>
                        <td>
                            <form class="admin-useraction"
                                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                                  method="post">
                                <select class="action" name="actions">
                                    <option value="freeze">Freeze</option>
                                    <option value="ban">Ban</option>
                                    <option value="restore">Restore</option>
                                </select>
                                <input type="submit" value="Confirm">
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>
</body>
</html>
