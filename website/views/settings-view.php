<?php
$settings = getSettings();
?>

<div class="content">
    <div class="settings">
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <div class='platform settings-message <?=$alertClass?>'>
            <?=$alertMessage?>
        </div>
        <?php endif; ?>
        <form class="settings-profile platform" method="post">
            <h5>Profiel Instellingen</h5>
            <ul>
                <li>
                    <label for="fname">Voornaam</label>
                    <input type="text"
                           name="fname"
                           id="fname"
                           maxlength="63"
                           placeholder="Voornaam"
                           title="Voornaam"
                           value="<?=$settings["fname"]?>"
                    >
                </li>
                <li>
                    <label for="lname">Achternaam</label>
                    <input type="text"
                           name="lname"
                           id="lname"
                           maxlength="63"
                           placeholder="Achternaam"
                           value="<?=$settings["lname"]?>"
                    >
                </li>
                <li>
                    <label for="location">Locatie</label>
                    <input type="text"
                           name="location"
                           id="location"
                           maxlength="50"
                           placeholder="Locatie"
                           value="<?=$settings["location"]?>"
                    >
                </li>
                <li>
                    <?php $currentbday = new DateTime($settings["birthdate"]); ?>
                    <label for="bday">Geboortedatum</label>
                    <select name='day' id="bday">
                        <?php for ($day = 1; $day <= 31; $day++): ?>
                        <option value='<?=$day?>'
                                <?=($day == $currentbday->format("d")) ? "selected" : ""?>
                        >
                            <?=$day?>
                        </option>
                        <?php endfor; ?>
                    </select>
                    <select name='month' id="bday">
                        <?php
                        $months = array ("januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus",
                            "september", "oktober", "november", "december");
                        for ($month = 1; $month <= 12; $month++):
                        ?>
                            <option value='<?=$month?>'
                                    <?=($month == $currentbday->format("m")) ? "selected" : ""?>
                            >
                                <?=$months[$month - 1]?>
                            </option>
                        <?php endfor; ?>
                    </select>
                    <select name='year' id="bday">
                        <?php
                        $now = (new DateTime)->format("Y");
                        for ($year = $now; $year >= 1900; $year--): ?>
                        <option value='<?=$year?>'
                                <?=($year == $currentbday->format("Y")) ? "selected" : ""?>
                        >
                            <?=$year?>
                        </option>
                        <?php endfor; ?>
                        <option value="680" <?=(680 == $currentbday->format("Y")) ? "selected" : ""?>>
                            680
                        </option>
                    </select>
                </li>
                <li>
                    <label for="showBday">Toon leeftijd</label>
                    <input type="checkbox"
                           name="showBday"
                           id="showBday"
                           <?=($settings["showBday"] ? "checked" : "")?>
                    >
                </li>
                <li>
                    <label for="showEmail">Toon Email</label>
                    <input type="checkbox"
                           name="showEmail"
                           id="showEmail"
                           <?=($settings["showEmail"] ? "checked" : "")?>
                    >
                </li>
                <li>
                    <label for="bio">Bio</label>
                    <textarea name="bio"
                              rows="5"
                              title="bio"
                              id="bio"
                              maxlength="1000"
                    ><?=$settings["bio"]?></textarea><span></span>
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
                    <img src="<?=$settings["profilepicture"]?>"
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
                    <label for="password-old">Oud wachtwoord</label>
                    <input type="password"
                           name="password-old"
                           id="password-old"
                           placeholder="Oud wachtwoord"
                           autocomplete="current-password"
                    >
                </li>
                <li>
                    <label for="password-new">Nieuw wachtwoord</label>
                    <input type="password"
                           name="password-new"
                           id="password-new"
                           placeholder="Nieuw wachtwoord"
                           autocomplete="new-password"
                    >
                </li>
                <li>
                    <label for="password-confirm">Bevestig wachtwoord</label>
                    <input type="password"
                           name="password-confirm"
                           id="password-confirm"
                           placeholder="Bevestig wachtwoord"
                           autocomplete="new-password"
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
                           maxlength="255"
                           value="<?=$settings["email"]?>"
                           disabled
                    >
                </li>
                <li>
                    <label for="email">Nieuw Email</label>
                    <input type="email"
                           name="email"
                           maxlength="255"
                           id="email"
                           placeholder="Nieuw Email"
                    >
                </li>
                <li>
                    <label for="email-confirm">Bevestig Email</label>
                    <input type="email"
                           name="email-confirm"
                           id="email-confirm"
                           maxlength="255"
                           placeholder="Bevestig Email"
                    >
                </li>
                <li>
                    <button type="submit"
                            name="form"
                            value="email">
                        Verander Email
                    </button>
                </li>
            </ul>
        </form>
    </div>
</div>