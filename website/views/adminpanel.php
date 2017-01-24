<script src="js/admin.js" charset="utf-8"></script>
<?php
require_once ("../queries/user.php");
require_once ("../queries/group_page.php");
?>
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
        <h5>Zoek naar gebruikers of groepen:</h5>
        <div class="admin-options">
            <form class="admin-searchform"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                  method="get">

                <div class="admin-searchbar">
                    Zoek: <input type="text"
                           name="search"
                           class="admin-searchinput"
                           placeholder="Naam"
                           value="<?php echo $search;?>">
                        Op: <select name="pagetype" id="pagetype" onchange="changeFilter()">
                        <option value="user"
                            <?php if (isset($pagetype) && $pagetype=="user") echo "selected";?>>
                            Gerbuiker
                        </option>
                        <option value="group"
                            <?php if (isset($pagetype) && $pagetype=="group") echo "selected";?>>
                            Groep
                        </option>
                    </select>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
                <div id="admin-filter">
                    <h5>Type gebruiker:</h5>
                    <input type="checkbox"
                           name="status[]"
                           id="all"
                           value="all"
                        <?php if (in_array("all", $status)) echo "checked";?>>
                    <label for="normal">Allemaal</label><br>
                    <input type="checkbox"
                           name="status[]"
                           id="normal"
                           value="user"
                           <?php if (in_array("user", $status)) echo "checked";?>>
                    <label for="normal">Normal</label><br>
                    <input type="checkbox"
                           name="status[]"
                           id="frozen"
                           value="frozen"
                           <?php if (in_array("frozen", $status)) echo "checked";?>>
                    <label for="frozen">Frozen</label><br>
                    <input type="checkbox"
                           name="status[]"
                           id="banned"
                           value="banned"
                           <?php if (in_array("banned", $status)) echo "checked";?>>
                    <label for="banned">Banned</label><br>
                    <input type="checkbox"
                           name="status[]"
                           id="admin"
                           value="admin"
                           <?php if (in_array("admin", $status)) echo "checked";?>>
                    <label for="admin">Admin</label><br>
                    <input type="checkbox"
                           name="status[]"
                           id="unvalidated"
                           value="unconfirmed"
                           <?php if (in_array("unconfirmed", $status)) echo "checked";?>>
                    <label for="unvalidated">Unvalidated</label><br>
                    <input type="checkbox"
                           name="status[]"
                           id="owner"
                           value="owner"
                           <?php if (in_array("owner", $status)) echo "checked";?>>
                    <label for="owner">Owner</label>
                </div>

                <div id="admin-groupfilter">
                    <h5>Type groep:</h5>
                    <input type="checkbox" name="groupstatus[]" id="all" value="all"
                        <?php if (in_array("all", $groupstatus)) echo "checked";?>>
                    <label for="hidden">Allemaal</label><br>
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
            </form>
            </div>
            <div class="admin-users">
                <div class="admin-usertitle">
                    <h4>Resultaat:</h4>
                    <span style="float: right">
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
                        Pagina: <form class="admin-pageselector"
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
                        <?php
                        echo "$minlist tot $mincount ($countresults totaal)";
                        ?>
                    </span>
                <form
                        id="admin-batchform"
                        action="<?php htmlspecialchars(basename($_SERVER['REQUEST_URI'])) ?>"
                        method="post">

                    <button type="submit" name="batchactions" id="freeze" value="frozen">Bevries</button>
                    <button type="submit" name="batchactions" id="ban" value="banned">Ban</button>
                    <button type="submit" name="batchactions" id="restore" value="user">Activeer</button>
                </form>
                </div>
                <table class="usertable">
                    <tr>
                        <th><input type="checkbox" id="checkall" name="checkall" onchange="checkAll(this)"></th>
                        <th class="table-username">Gebruikersnaam</th>
                        <th class="table-status">Status</th>
                        <th class="table-comment">Aantekening</th>
                        <th class="table-action">Actie</th>
                    </tr>

                    <!-- Table construction via php PDO. -->
                    <?php
                    $listn = ($currentpage-1) * $perpage;
                    $listm = $currentpage * $perpage;

                    if ($pagetype == 'user') {
                        $q = searchSomeUsersByStatus($listn, $listm, $search, $status);
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
                            <option value='frozen'>Bevries</option>
                            <option value='banned'>Ban</option>
                            <option value='user'>Activeer</option>
                            </select>
                            <input type='hidden' name='userID' value='$userID'>
                            <input type='submit' value='Confirm'>
                            </form>
                            </td>
                            </tr>
                            ");
                        }
                    } else {
                        $q = searchSomeGroupsByStatus($listn, $listm, $search, $groupstatus);

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
    </div>
</div>
</body>
</html>
