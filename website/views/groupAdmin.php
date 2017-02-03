<?php
require_once "../queries/connect.php";
require_once "../queries/groupAdmin.php";
require_once "../queries/checkInput.php";
$groupinfo = getGroupSettings($_GET["groupID"]);
?>
<div class="content">
    <div class="settings">
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <div class='platform settings-message <?=$alertClass?>'>
            <?=$alertMessage?>
        </div>
        <?php endif; ?>
        <div class="platform">
            <ul>
                <li>
                    <label></label>
                    <a href="group.php?groupname=<?=$groupinfo["name"]?>">
                        <button><i class="fa fa-chevron-left"></i> Terug naar de groep</button>
                    </a>
                </li>
            </ul>
        </div>
        <form class="platform" method="post">
            <h5>Groep Instellingen</h5>
            <input type="hidden" name="groupID" value="<?=$_GET["groupID"]?>">
            <ul>
                <li>
                    <label for="name">Groepsnaam</label>
                    <input type="text"
                           name="name"
                           id="name"
                           maxlength="63"
                           placeholder="Groepsnaam"
                           title="Groepsnaam"
                           value="<?=$groupinfo["name"]?>"
                    >
                </li>
                <li>
                    <label for="bio">Bio</label>
                    <textarea name="bio"
                              rows="5"
                              title="bio"
                              id="bio"
                              maxlength="1000"
                    ><?=$groupinfo["description"]?></textarea>
                    <label></label>
                </li>
                <li>
                    <label></label>
                    <button type="submit"
                            name="form"
                            value="group"
                    ><i class="fa fa-save"></i> Opslaan</button>
                </li>
            </ul>
        </form>
        <form class="platform" method="post" enctype="multipart/form-data">
            <h5>Verander groepsafbeelding.</h5>
            <input type="hidden" name="groupID" value="<?=$_GET["groupID"]?>">
            <ul>
                <li>
                    <label>Huidige profielfoto</label>
                    <img src="<?=$groupinfo["picture"]?>"
                         class="group-picture"
                    >
                </li>
                <li>
                    <label>Selecteer foto</label>
                    <input type="file"
                           name="pp"
                           accept="image/*"
                           size="4000000"
                           required
                    >
                </li>
                <li>
                    <label></label>
                    <button type="submit"
                            name="form"
                            value="picture"
                    ><i class="fa fa-picture-o"></i> Verander profielfoto</button>
                </li>
            </ul>
        </form>
        <form class="platform" method="post">
            <h5>Voeg een admin/mod toe</h5>
            <ul>
                <il>
                    <input name="groupID" value="<?=$_GET["groupID"]?>" type="hidden">
                    <label>Selecteer gebruiker</label>
                    <select name="userID">
                        <option disabled selected>Geen gebruiker geselecteerd:</option>
                        <?php
                        $groupMembers = getAllGroupUsers($_GET["groupID"]);
                        foreach ($groupMembers as $groupMember) {?>
                            <option value="<?=$groupMember["userID"]?>">
                                <?=$groupMember["fullname"]?> (<?=$groupMember["username"]?>)
                            </option>
                        <?php } ?>
                    </select>
                    <button name="form"
                            value="admin"
                    >
                        Maak Admin
                    </button>
                    <button name="form"
                            value="mod"
                    >
                        Maak Moderator
                    </button>
                </il>
            </ul>
        </form>
        <form class="platform" method="post">
            <h5>Verwijder een admin/mod</h5>
            <ul>
                <il>
                    <input name="groupID" value="<?=$_GET["groupID"]?>" type="hidden">
                    <label>Selecteer gebruiker</label>
                    <select name="userID">
                        <option disabled selected>Geen gebruiker geselecteerd:</option>
                        <?php
                        $groupAdmins = getAllGroupAdmins($_GET["groupID"]);
                        foreach ($groupAdmins as $groupAdmin) {?>
                            <option value="<?=$groupAdmin["userID"]?>">
                                <?=$groupAdmin["fullname"]?> (<?=$groupAdmin["username"]?>) (<?=$groupAdmin["role"]?>)
                            </option>
                        <?php } ?>
                        <?php
                        $groupMods = getAllGroupMods($_GET["groupID"]);
                        foreach ($groupMods as $groupMod) {?>
                            <option value="<?=$groupMod["userID"]?>">
                                <?=$groupMod["fullname"]?> (<?=$groupMod["username"]?>) (<?=$groupMod["role"]?>)
                            </option>
                        <?php } ?>
                    </select>
                    <button name="form"
                            value="deadmin"
                    >
                        Verwijder
                    </button>
                </il>
            </ul>
        </form>
        <form class="platform" method="post">
            <ul>
                <h5>Verwijder groep</h5>
                <li>
                    <label></label>
                    <input name="groupID" value="<?=$_GET["groupID"]?>" type="hidden">
                    <button class="red"
                            name="form"
                            value="delete"
                    ><i class="fa fa-trash"></i> Verwijder groep</button>
                </li>
            </ul>
        </form>
        <div class="platform">
            <ul>
                <li>
                    <label></label>
                    <a href="group.php?groupname=<?=$groupinfo["name"]?>"><button><i class="fa fa-chevron-left"></i> Terug naar de groep</button></a>
                </li>
            </ul>
        </div>
    </div>        
</div>