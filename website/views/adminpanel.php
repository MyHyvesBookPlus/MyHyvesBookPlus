<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <script src="/js/admin.js" charset="utf-8"></script>
    <?php
        include_once("../queries/user.php");
        include_once("../queries/group_page.php");
    ?>
</head>
<body>

<!-- function test_input taken from http://www.w3schools.com/php/php_form_validation.asp -->
<?php
$search = "";
$currentpage = 1;
$perpage = 20;
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
        changeUserStatusByID($_POST["userID"], $_POST["actions"]);
    }

    if (isset($_POST["actions"]) && isset($_POST["groupID"])) {
        changeGroupStatusByID($_POST["groupID"], $_POST["actions"]);
    }

    if (isset($_POST["batchactions"]) && isset($_POST["checkbox-user"])) {
        changeMultipleUserStatusByID($_POST["checkbox-user"], $_POST["batchactions"]);
    }

    if (isset($_POST["groupbatchactions"]) && isset($_POST["checkbox-group"])) {
        changeMultipleGroupStatusByID($_POST["checkbox-group"], $_POST["groupbatchactions"]);
    }

    if (isset($_POST["pageselect"])) {
        $currentpage = $_POST["pageselect"];
    }

}

$listn = ($currentpage-1) * $perpage;
$listm = $currentpage * $perpage;

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

                    <input type="checkbox" name="status[]" id="normal" value="user"
                           <?php if (in_array("user", $status)) echo "checked";?>>
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
                    <input type="checkbox" name="status[]" id="unvalidated" value="unconfirmed"
                           <?php if (in_array("unconfirmed", $status)) echo "checked";?>>
                    <label for="unvalidated">Unvalidated</label><br>
                    <input type="checkbox" name="status[]" id="owner" value="owner"
                           <?php if (in_array("owner", $status)) echo "checked";?>>
                    <label for="owner">Owner</label>
                </div>

                <div class="admin-groupfilter" id="admin-groupfilter">
                    <h2>Show:</h2>

                    <input type="checkbox" name="groupstatus[]" id="hidden" value="hidden"
                           <?php if (in_array("hidden", $groupstatus)) echo "checked";?>>
                    <label for="hidden">Hidden</label><br>
                    <input type="checkbox" name="groupstatus[]" id="public" value="public"
                           <?php if (in_array("public", $groupstatus)) echo "checked";?>>
                    <label for="public">Public</label><br>
                    <input type="checkbox" name="groupstatus[]" id="membersonly" value="membersonly"
                           <?php if (in_array("membersonly", $groupstatus)) echo "checked";?>>
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
                        <input type="radio" name="batchactions" id="freeze" value="frozen">
                        <label for="freeze">Freeze</label><br>
                        <input type="radio" name="batchactions" id="ban" value="banned">
                        <label for="ban">Ban</label><br>
                        <input type="radio" name="batchactions" id="restore" value="user">
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
                        <input type="radio" name="groupbatchactions" id="hide" value="hidden">
                        <label for="hide">Hide</label><br>
                        <input type="radio" name="groupbatchactions" id="public" value="public">
                        <label for="public">Public</label><br>
                        <input type="radio" name="groupbatchactions" id="membersonly" value="membersonly">
                        <label for="membersonly">Member</label><br><br>
                        <input type="submit" value="Confirm">
                    </form>
                </div>
            </div>
            <br>

            <div class="admin-users">
                <div class="admin-usertitle">
                    <div class="admin-userheading">
                        <h2>Users:</h2>
                    </div>
                    <div class="admin-pageui">
                        <?php
                        if ($pagetype == "user") {
                            $pages = countSomeUsersByStatus($search, $status);
                        } else {
                            $pages = countSomeGroupsByStatus($search, $groupstatus);
                        }
                        $countresults = $pages->fetchColumn();
                        $mincount = min($listm, $countresults);
                        $minlist = min($listn + 1, $countresults);
                        ?>
                        <p class="pagenumber">Current page:</p>
                        <form class="admin-pageselector"
                              action="<?php htmlspecialchars(basename($_SERVER['REQUEST_URI'])) ?>"
                              method="post">
                              <select class="admin-pageselect"
                                      name="pageselect"
                                      onchange="this.form.submit()"
                                      value="">
                                  <?php
                                  for ($i=1; $i <= ceil($countresults / $perpage); $i++) {
                                      if ($currentpage == $i) {
                                          echo "<option value='$i' selected>$i</option>";
                                      } else {
                                          echo "<option value='$i'>$i</option>";
                                      }
                                  }
                                  ?>
                              </select>
                        </form>
                        <p class="entriesshown">
                        <?php
                        echo "Showing results $minlist to $mincount out of $countresults";
                        ?>
                    </div>
                </div> <br>

                <table class="usertable">
                    <tr>
                        <th class="table-checkbox">
                            <input type="checkbox" id="checkall" name="checkall" onchange="checkAll(this)">
                        </th>
                        <th class="table-username">User</th>
                        <th class="table-status">Status</th>
                        <th class="table-comment">Comment</th>
                        <th class="table-action">Action</th>
                    </tr>

                    <!-- Table construction via php PDO. -->
                    <?php
                    $listn = ($currentpage-1) * $perpage;
                    $listm = $currentpage * $perpage;

                    if ($pagetype == 'user') {
                        $q = searchSomeUsersByStatus($listn, $perpage, $search, $status);

                        while($user = $q->fetch(PDO::FETCH_ASSOC)) {
                            $userID = $user['userID'];
                            $username = $user['username'];
                            $role = $user['role'];
                            $bancomment = $user['bancomment'];
                            $thispage = htmlspecialchars(basename($_SERVER['REQUEST_URI']));
                            $function = "checkCheckAll(document.getElementById('checkall'))";

                            echo("
                            <tr>
                            <td><input type='checkbox'
                            name='checkbox-user[]'
                            class='checkbox-list'
                            value='$userID'
                            form='admin-batchform'
                            onchange=" . "$function" . ">
                            </td>
                            <td>$username</td>
                            <td>$role</td>
                            <td>$bancomment</td>
                            <td>
                            <form class='admin-useraction'
                            action='$thispage'
                            method='post'>
                            <select class='action' name='actions'>
                            <option value='frozen'>Freeze</option>
                            <option value='banned'>Ban</option>
                            <option value='user'>Restore</option>
                            </select>
                            <input type='hidden' name='userID' value='$userID'>
                            <input type='submit' value='Confirm'>
                            </form>
                            </td>
                            </tr>
                            ");
                        }
                    } else {
                        $q = searchSomeGroupsByStatus($listn, $perpage, $search, $groupstatus);

                        while ($group = $q->fetch(PDO::FETCH_ASSOC)) {
                            $groupID = $group['groupID'];
                            $name = $group['name'];
                            $role = $group['status'];
                            $description = $group['description'];
                            $thispage = htmlspecialchars(basename($_SERVER['REQUEST_URI']));
                            $function = "checkCheckAll(document.getElementById('checkall'))";

                            echo("
                            <tr>
                            <td><input type='checkbox'
                            name='checkbox-group[]'
                            class='checkbox-list'
                            value='$groupID'
                            form='admin-groupbatchform'
                            onchange=" . "$function" . ">
                            </td>
                            <td>$name</td>
                            <td>$role</td>
                            <td>$description</td>
                            <td>
                            <form class='admin-groupaction'
                            action='$thispage'
                            method='post'>
                            <select class='action' name='actions'>
                            <option value='hidden'>Hide</option>
                            <option value='public'>Public</option>
                            <option value='membersonly'>Members</option>
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
    </div>
</div>
</body>
</html>
