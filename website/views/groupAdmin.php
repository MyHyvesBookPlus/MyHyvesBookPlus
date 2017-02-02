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
                        <button class="fa fa-chevron-left"> Terug naar de groep</button>
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
                            class="fa fa-save"
                    > Opslaan</button>
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
                            class="fa fa-picture-o"
                    > Verander profielfoto</button>
                </li>
            </ul>
        </form>
        <div class="platform">
            <ul>
                <li>
                    <label></label>
                    <a href="group.php?groupname=<?=$groupinfo["name"]?>"><button class="fa fa-chevron-left"> Terug naar de groep</button></a>
                </li>
            </ul>
        </div>
    </div>        
</div>