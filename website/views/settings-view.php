<div class="content">
    <div class="settings">
        <form class="settings-profile platform">
            <h5>Profiel Instllingen</h5>
            <label for="first-name">Voornaam</label>
            <input type="text"
                   name="first-name"
                   id="first-name"
                   placeholder="Voornaam"
                   title="Voornaam"
            ><br />
            <label for="last-name">Achternaam</label>
            <input type="text"
                   name="last-name"
                   id="last-name"
                   placeholder="Lastname"
            ><br />
            <label for="place">Woonplaats</label>
            <input type="text"
                   name="place"
                   id="place"
                   placeholder="Woonplaats"
            ><br />
            <label for="bday">Geboortedatum</label>
            <input type="date"
                   name="bday"
                   id="bday"
                   placeholder="01/01/1900"
            ><br />
            <label for="location">Locatie</label>
            <input type="text"
                   name="location"
                   id="location"
                   placeholder="Locatie"
            ><br />
            <label for="bio">Bio</label>
            <textarea name="bio"
                      rows="5"
                      cols="10"
                      title="bio"
                      id="bio"
            ></textarea>
            <br />

            <label></label>
            <input type="submit"
                   value="Opslaan"
            >
        </form>


        <form class="settings-password platform" method="post">
            <h5>Verander Wachtwoord</h5>
            <br />
            <input type="password"
                   name="password-old"
                   placeholder="Oud wachtwoord"
            ><br />
            <input type="password"
                   name="password-new"
                   placeholder="Nieuw wachtwoord"
            ><br />
            <input type="password"
                   name="password-confirm"
                   placeholder="Bevestig wachtwoord"
            ><br />
            <input type="submit"
                   value="Verander wachtwoord"
            >
        </form>

        <form class="settings-email platform" method="post">
            <h5>Verander Email</h5>
            <br />
            <input type="email"
                   name="email"
                   placeholder="Nieuw Email-adres"
            ><br />
            <input type="email"
                   name="email-confirm"
                   placeholder="Bevestig Email"
            ><br />
            <input type="submit"
                   value="Verander Email"
            >
        </form>
    </div>
</div>