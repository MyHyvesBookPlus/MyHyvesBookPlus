<div class="content">
    <div class='platform alertbox' id="alertbox">
        <span class="alerttext" id="alerttext"></span>
    </div>

    <div class="user-box">
        <img alt="<?= $user["fname"] ?>" class="profile-picture main-picture <?= $user["onlinestatus"] ?>" src="<?= $user["profilepicture"] ?>"><br />
        <div class="platform">
            <div class="status-buttons-container">
                <div>
                    <button disabled class="gray">
                        <?= $user["onlinestatus"] ?>
                    </button>
                </div>
                <div>
                    <button disabled class="gray">
                        <?= $user["role"] ?>
                    </button>
                </div>
            </div>
            <div class="friend-button-container">
                <p>:)</p>
                <p>Je ziet er goed uit vandaag</p>
            </div>
            <div class="profile-info">
                <h2><?= $user["fname"]?> <?=$user["lname"]?></h2>
                <h5><?=$user["username"]?></h5>
                <?php
                if (strlen($user["bio"]) <= 50 and $showProfile) {
                    echo "<p>" . $user["bio"] . "</p>";
                } ?>
            </div>
        </div>
    </div>
    <?php if (strlen($user["bio"]) > 50 and $showProfile) {
        echo "<div class='platform'><h3>Bio:</h3><p>" . $user["bio"] . "</p></div>";
    } ?>

    <?php if($showProfile) { ?>
    <div class="item-box platform">
        <h3>Informatie</h3>
        <ul>
            <?php if ($user["showBday"]) { ?>
            <li>Leeftijd: <?= getAge($user["birthdate"]) ?> jaar</li>
            <?php } ?>
            <?php if ($user["showEmail"]) { ?>
                <li>Email: <?= $user["email"] ?></li>
            <?php } ?>
            <li>Locatie: <?= $user["location"] ?></li>
            <li>Lid sinds: <?= nicetime($user["creationdate"]) ?></li>
        </ul>
    </div>

    <div class="item-box platform">
        <h3>Vrienden</h3>
        <p>
            <?php
                $friendcount = $profile_friends->rowCount();
                $frienddif = $friendcount - 7;

                for ($i = 0; $i < min($friendcount, 7); $i += 1) {
                    $friend = $profile_friends->fetch();
                    echo "<a href='profile.php?username=${friend["username"]}' data-title='${friend["username"]}'><img class='profile-picture' height='42' width='42' src='${friend["profilepicture"]}' alt='${friend["username"]}' /></a>";
                }

                if ($frienddif > 0) {
                    echo $frienddif === 1 ? "en nog 1 andere." : "...en nog $frienddif anderen.";
                }

                if($profile_friends->rowCount() === 0) {
                    echo "<p>Deze gebruiker heeft nog geen vrienden gemaakt.</p>";
                }
            ?>
        </p>
    </div>

    <div class="item-box platform">
        <h3>Groepen</h3>
        <p>
            <?php
                $groupcount = $profile_groups->rowCount();
                $groupdif = $groupcount - 7;

                for ($i = 0; $i < min($groupcount, 7); $i += 1) {
                    $group = $profile_groups->fetch();
                    echo "<a href='group.php?groupname=${group['name']}' data-title='${group["name"]}'><img class='group-picture' src='${group["picture"]}' alt='${group["name"]}s logo'></a>";
                }

                if ($groupdif > 0) {
                    echo $groupdif === 1 ? "en nog 1 andere." : "...en nog $groupdif anderen.";
                }

                if($profile_groups->rowCount() === 0) {
                    echo "<p>Deze gebruiker is nog geen lid van een groep.</p>";
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
    <?php } ?>
</div>