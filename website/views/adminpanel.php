
<!-- function test_input taken from http://www.w3schools.com/php/php_form_validation.asp -->
<?php
$search = "";
$status = array("user", "frozen", "banned", "unconfirmed", "admin", "owner");
$groupstatus = array("hidden", "public", "membersonly");
$pagetype = "user";
$userinfo = getRoleByID($_SESSION['userID']);

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

?>

<div class="content">
    <div class="platform admin-panel">
        <h5>Zoek naar gebruikers of groepen:</h5>
        <div class="admin-options">
            <form class="admin-searchform"
                  id="admin-searchform"
                  action="javascript:searchFromOne();"
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
                            Gebruiker
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
                           id="normal"
                           value="user"
                        <?php if (in_array("user", $status)) echo "checked";?>>
                    <label for="normal">Normaal</label><br>
                    <input type="checkbox"
                           name="status[]"
                           id="frozen"
                           value="frozen"
                        <?php if (in_array("frozen", $status)) echo "checked";?>>
                    <label for="frozen">Bevroren</label><br>
                    <input type="checkbox"
                           name="status[]"
                           id="banned"
                           value="banned"
                        <?php if (in_array("banned", $status)) echo "checked";?>>
                    <label for="banned">Verbannen</label><br>
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
                    <label for="unvalidated">Ongevalideerd</label><br>
                    <input type="checkbox"
                           name="status[]"
                           id="owner"
                           value="owner"
                        <?php if (in_array("owner", $status)) echo "checked";?>>
                    <label for="owner">Eigenaar</label>
                </div>

                <div id="admin-groupfilter">
                    <h5>Type groep:</h5>
                    <input type="checkbox" name="groupstatus[]" id="hidden" value="hidden"
                        <?php if (in_array("hidden", $groupstatus)) echo "checked";?>>
                    <label for="hidden">Verborgen</label><br>
                    <input type="checkbox" name="groupstatus[]" id="public" value="public"
                        <?php if (in_array("public", $groupstatus)) echo "checked";?>>
                    <label for="public">Publiek</label><br>
                    <input type="checkbox" name="groupstatus[]" id="membersonly" value="membersonly"
                        <?php if (in_array("membersonly", $groupstatus)) echo "checked";?>>
                    <label for="membersonly">Alleen Leden</label><br>
                </div>
            </form>
        </div>

        <div class="admin-users">
            <div class="admin-usertitle">
                <h4>Resultaat:</h4>
                <div style="float: right" id="admin-pageinfo">

                </div>
                <form id="admin-batchform"
                      onsubmit="adminUpdate(this); return false;">

                    <input type="hidden" name="batchactions" id="batchinput">
                    <button type="submit" name="batchactions" id="freeze" value="frozen">Bevries</button>
                    <button type="submit" name="batchactions" id="ban" value="banned">Ban</button>
                    <button type="submit" name="batchactions" id="restore" value="user">Activeer</button>
                    <button type="submit" name="batchactions" id="unconfirm" value="unconfirmed">Maak Ongevalideerd</button>
                    <?php
                    if ($userinfo == 'owner') {
                        echo "<button type=\"submit\" 
                                      name=\"batchactions\" 
                                      id=\"admin\" 
                                      value=\"admin\">Maak Admin</button>
                              <button type=\"submit\" 
                                      name=\"batchactions\" 
                                      id=\"owner\" 
                                      value=\"owner\">Maak Eigenaar</button>";
                    }
                    ?>
                </form>
                <form id="admin-groupbatchform"
                      onsubmit="adminUpdate(this);  return false;">

                    <input type="hidden" name="groupbatchactions" id="groupbatchinput">
                    <button type="submit" name="batchactions" id="hide" value="hidden">Verborgen</button>
                    <button type="submit" name="batchactions" id="ban" value="public">Publiek</button>
                    <button type="submit" name="batchactions" id="members" value="membersonly">Alleen Leden</button>
                </form>
            </div>

            <table class="usertable" id="usertable">

            </table>
        </div>
    </div>
</div>
</body>
</html>