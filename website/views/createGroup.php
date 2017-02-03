<?php
?>

<div class="content">
    <div class="createGroup">
        <form class="platform settings" method="post" action="createGroup.php" enctype="multipart/form-data">
            <h5>Maak een groep!</h5>
            <ul>
                <li>
                    <label for="groupName">Groepsnaam</label>
                    <input type="text"
                           name="groupName"
                           id="groupName"
                           maxlength="63"
                           placeholder="Groepsnaam"
                    >
                </li>
                <li>
                    <label for="bio">Bio</label>
                    <textarea name="bio"
                              rows="5"
                              title="bio"
                              id="bio"
                              maxlength="1000"
                    ></textarea>
                </li>
                <li>
                    <label>Selecteer foto</label>
                    <input type="file"
                           name="pp"
                           accept="image/*"
                           size="4000000"
                    >
                </li>
                <li>
                    <label></label>
                    <button type="submit">Maak Groep</button>
                </li>
            </ul>
        </form>
    </div>
</div>
