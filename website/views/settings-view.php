<?php
$settings = getSettings();
?>

<div class="content">
    <div class="settings">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<div class='platform settings-message ${result["type"]}'>
            ${result["message"]}
        </div>";
        }
        ?>
        <form class="settings-profile platform" method="post">
            <h5>Profiel Instellingen</h5>
            <ul>
                <li>
                    <label for="fname">Voornaam</label>
                    <input type="text"
                           name="fname"
                           id="fname"
                           placeholder="Voornaam"
                           title="Voornaam"
                           value="<?= $settings["fname"]?>"
                    >
                </li>
                <li>
                    <label for="lname">Achternaam</label>
                    <input type="text"
                           name="lname"
                           id="lname"
                           placeholder="Achternaam"
                           value="<?= $settings["lname"]?>"
                    >
                </li>
                <li>
                    <label for="location">Locatie</label>
                    <input type="text"
                           name="location"
                           id="location"
                           placeholder="Locatie"
                           value="<?= $settings["location"]?>"
                    >
                </li>
                <li>
                    <label for="bday">Geboortedatum</label>
                    <input type="date"
                           name="bday"
                           id="bday"
                           placeholder="yyyy-mm-dd"
                           value="<?= $settings["birthdate"]?>"
                    >
                </li>
                <li>
                    <label for="bio">Bio</label>
                    <textarea name="bio"
                              rows="5"
                              title="bio"
                              id="bio"
                    ><?= $settings["bio"]?></textarea>
                </li>
                <li>
                    <label></label>
                    <button type="submit"
                            value="profile"
                            name="form"
                    >Opslaan</button>
                </li>
            </ul>
        </form>
        <form class="settings-profilepictue platform" method="post">
            <h5>Verander profielfoto</h5>
            <ul>
                <li>
                    <label>Huidige profielfoto</label>
                    <img src="<?= $settings["profilepicture"] ?>"
                         class="profile-picture"
                    >
                </li>
                <li>
                    <label>Selecteer foto</label>
                    <input type="file"
                           name="pp"
                           accept="image/jpeg,image/gif,image/png"
                    >
                </li>
                <li>
                    <label></label>
                    <button type="submit"
                            name="form"
                            value="picture"
                    >Verander profielfoto</button>
                </li>
            </ul>
        </form>
        <form class="settings-password platform item-box" method="post">
            <h5>Verander Wachtwoord</h5>
            <ul>
                <li>
                    <label>Oud wachtwoord</label>
                    <input type="password"
                           name="password-old"
                           placeholder="Oud wachtwoord"
                    >
                </li>
                <li>
                    <label>Nieuw wachtwoord</label>
                    <input type="password"
                           name="password-new"
                           placeholder="Nieuw wachtwoord"
                    >
                </li>
                <li>
                    <label>Bevestig wachtwoord</label>
                    <input type="password"
                           name="password-confirm"
                           placeholder="Bevestig wachtwoord"
                    >
                </li>
                <li>
                    <button type="submit"
                            name="form"
                            value="password"
                    >Verander wachtwoord</button>
                </li>
            </ul>
        </form>

        <form class="settings-email platform item-box" method="post">
            <h5>Verander Email</h5>
            <ul>
                <li>
                    <label for="email-old">Huidig Email </label>
                    <input type="email"
                           id="email-old"
                           value="<?= $settings["email"]?>"
                           disabled
                    >
                </li>
                <li>
                    <label for="email">Nieuw Email</label>
                    <input type="email"
                           name="email"
                           id="email"
                           placeholder="Nieuw Email"
                    >
                </li>
                <li>
                    <label for="email-confirm">Bevestig Email</label>
                    <input type="email"
                           name="email-confirm"
                           id="email-confirm"
                           placeholder="Bevestig Email"
                    >
                </li>
                <li>
                    <button type="submit"
                            name="form"
                            value="email"
                    >Verander Email</button>
                </li>
            </ul>
        </form>
    </div>
</div>