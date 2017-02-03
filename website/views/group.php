<div class="content">
    <div class="user-box">
        <img alt="<?= $group["name"] ?>" class="group-picture main-picture" src="<?= $group["picture"] ?>"><br />
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
                $membercount = $members->rowCount();
                $memberdif = $membercount - 7;

                for ($i = 0; $i < min($membercount, 7); $i += 1) {
                    $member = $members->fetch();
                    echo "<a href=\"profile.php?username=" . $member["username"] . "\" data-title=\"" . $member["username"] . "\"><img class=\"profile-picture\" src=\"" . $member["profilepicture"] . "\" alt=\"" . $member["username"] . "'s profielfoto\"></a>";
                }

                if ($memberdif > 0) {
                    echo $memberdif === 1 ? "en nog 1 andere." : "...en nog $memberdif anderen.";
                }

            ?>
        </p>
    </div>

    <div class="posts">

    </div>

    <div class="noposts platform">
        <p>Geen posts meer!</p>
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