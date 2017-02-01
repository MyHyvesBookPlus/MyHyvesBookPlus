<div class="content">
    <div class="user-box">
        <img class="group-picture main-picture" src="<?= $group["picture"] ?>"><br />
        <div class="platform">
            <div class="status-buttons-container">
                <button disabled class="gray"><?= $group["status"] ?></button>
            </div>
            <div class="group-button-container"></div>
            <div class="profile-info">
                <h2><?= $group["name"]?></h2>
                <?= $group["description"] ?>
            </div>
        </div>
    </div>
    <div class="item-box-full-width platform">
        <h2>Leden (<?= $group['members'] ?>)</h2>
        <p>
            <?php
                foreach($members as $member) {
                    echo "<a href=\"profile.php?username=" . $member["username"] . "\" data-title=\"" . $member["username"] . "\"><img class=\"profile-picture\" src=\"" . $member["profilepicture"] . "\" alt=\"" . $member["username"] . "'s profielfoto\"></a>";
                }
            ?>
        </p>
    </div>

    <div class="posts">

    </div>

    <div class="modal">
        <div class="modal-content platform">
            <div class="modal-close">
                &times;
            </div>
            <div class="modal-response" id="modal-response">
                <span class="modal-default">Aan het laden...</span>
            </div>
        </div>
    </div>
</div>