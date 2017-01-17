<div class="content">
    <div class="settings">
        <form class="settings-profile platform">
            <h5>Profiel Instellingen</h5>
            <ul>
                <li>
                    <label for="first-name">Voornaam</label>
                    <input type="text"
                           name="first-name"
                           id="first-name"
                           placeholder="Voornaam"
                           title="Voornaam"
                    >
                </li>
                <li>
                    <label for="last-name">Achternaam</label>
                    <input type="text"
                           name="last-name"
                           id="last-name"
                           placeholder="Achternaam"
                    >
                </li>
                <li>
                    <label for="place">Woonplaats</label>
                    <input type="text"
                           name="place"
                           id="place"
                           placeholder="Woonplaats"
                    >
                </li>
                <li>
                    <label for="bday">Geboortedatum</label>
                    <input type="date"
                           name="bday"
                           id="bday"
                           placeholder="01/01/1900"
                    >
                </li>
                <li>
                    <label for="location">Locatie</label>
                    <input type="text"
                           name="location"
                           id="location"
                           placeholder="Locatie"
                    >
                </li>
                <li>
                    <label for="bio">Bio</label>
                    <textarea name="bio"
                              rows="5"
                              title="bio"
                              id="bio"
                    ></textarea>
                </li>
                <li>
                    <label></label>
                    <input type="submit"
                           value="Opslaan"
                    >
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
                    <label></label>
                    <input type="submit"
                           value="Verander wachtwoord"
                    >
                </li>
            </ul>
        </form>

        <form class="settings-email platform item-box" method="post">
            <h5>Verander Email</h5>
            <ul>
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
                    <label></label>
                    <input type="submit"
                           value="Verander Email"
                    >
                </li>
            </ul>
        </form>
    </div>
</div>