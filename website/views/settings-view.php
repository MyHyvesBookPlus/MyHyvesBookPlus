<?php
$settings = getSettings();
?>

<div class="content">
    <div class="settings">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<div class='platform settings-message $alertClass '>
            $alertMessage
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
                    <?php $currentbday = new DateTime($settings["birthdate"]);?>
                    <select name='day'>";
                        <?php for ($day = 1; $day < 32; $day++):
                        $day = sprintf("%02d", $day); ?>
                        <option value='<?=$day?>'
                                <?= ($day == $currentbday->format("d")) ? "selected" : ""?>
                        ><?=$day?></option>";

                        <?php endfor; ?>
                    </select>
                    <select name='month'>
                        <option value='01' <?=('01' == $currentbday->format("m")) ? "selected" : ""?>>januari</option>
                        <option value='02' <?=('02' == $currentbday->format("m")) ? "selected" : ""?>>februari</option>
                        <option value='03' <?=('03' == $currentbday->format("m")) ? "selected" : ""?>>maart</option>
                        <option value='04' <?=('04' == $currentbday->format("m")) ? "selected" : ""?>>april</option>
                        <option value='05' <?=('05' == $currentbday->format("m")) ? "selected" : ""?>>mei</option>
                        <option value='06' <?=('06' == $currentbday->format("m")) ? "selected" : ""?>>juni</option>
                        <option value='07' <?=('07' == $currentbday->format("m")) ? "selected" : ""?>>juli</option>
                        <option value='08' <?=('08' == $currentbday->format("m")) ? "selected" : ""?>>augustus</option>
                        <option value='09' <?=('09' == $currentbday->format("m")) ? "selected" : ""?>>september</option>
                        <option value='10' <?=('10' == $currentbday->format("m")) ? "selected" : ""?>>oktober</option>
                        <option value='11' <?=('11' == $currentbday->format("m")) ? "selected" : ""?>>november</option>
                        <option value='12' <?=('12' == $currentbday->format("m")) ? "selected" : ""?>>december</option>
                    </select>
                    <select name='year'>";
                        <?php
                        $now = (new DateTime)->format("Y");
                        for ($year = $now; $year >= 1900; $year--): ?>
                        <option value='<?=$year?>'
                            <?= ($year == $currentbday->format("Y")) ? "selected" : ""?>
                        ><?=$year?></option>
                        <?php endfor; ?>
                        </select>
                </li>
                <li>
                    <label for="showBday">Toon leeftijd</label>
                    <input type="radio"
                           name="showBday"
                           id="showBday"
                           value="1"
                           <?= ($settings["showBday"] ? "checked" : "")?>
                    > Ja
                    <input type="radio"
                           name="showBday"
                           id="showBday"
                           value="0"
                           <?= ($settings["showBday"] ? "" : "checked")?>
                           > Nee
                </li>
                <li>
                    <label for="showEmail">Toon Email</label>
                    <input type="radio"
                           name="showEmail"
                           id="showEmail"
                           value="1"
                           <?= ($settings["showEmail"] ? "checked" : "")?>
                    > Ja
                    <input type="radio"
                           name="showEmail"
                           id="showEmail"
                           value="0"
                        <?= ($settings["showEmail"] ? "" : "checked")?>
                    > Nee
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
        <form class="settings-profilepictue platform" method="post" enctype="multipart/form-data">
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
                           accept="image/*"
                           size="4000000"
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
