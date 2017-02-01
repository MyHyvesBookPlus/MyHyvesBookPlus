<div class="content">
    <div class="profile-box platform">
        <img class="left main-picture" src="<?= $group['picture'] ?>">
        <div class="profile-button">
            <p><img src="img/leave-group.png"> Groep verlaten</p>
        </div>
        <h1 class="profile-username"><?= $group['name'] ?></h1>
        <p><?= $group['description'] ?></p>
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