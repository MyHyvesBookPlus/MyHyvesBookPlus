<div>
    <img style="width:50%;margin-left:25%"
         src="/img/top-logo.png"
         alt="MyHyvesbook+">
</div>

<div class="platform">
  <h1>Registreer uw account</h1>
    <!-- Register Content -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
          return= $correct
          method="post">

        <!-- Error message -->
        <div class="login_containerfault"><?php echo $genericErr;?></span></div>

        <!-- Register name -->
        <div class="login_containerregister">
            <label><b>Naam</b></label>
            <input type="text"
                   placeholder="Voer uw naam in"
                   name="name"
                   value="<?php echo $name ?>"
                   title="Mag alleen letters bevatten"
                   >
            *<span class="error"><?php echo $nameErr;?></span>
        </div>

        <!-- Register surname -->
        <div class="login_containerregister">
            <label><b>Achternaam</b></label>
            <input type="text"
                   placeholder="Voer uw achternaam in"
                   name="surname"
                   value="<?php echo $surname ?>"
                   title="Mag alleen letters bevatten"
                   >
            *<span class="error"> <?php echo $surnameErr;?></span>
        </div>

        <!-- Register birthday -->
        <div class="login_containerregister">
            <label><b>Geboortedatum</b></label>
            <input type="text"
                   name="bday"
                   value="<?php echo $bday ?>"
                   id="bday"
                   placeholder="1996/01/01"
                   data-fv-date-max=""
                   >
            *<span class="error"> <?php echo $bdayErr;?></span>
        </div>

        <!-- Register username -->
        <div class="login_containerregister">
            <label><b>Gebruikersnaam</b></label>
            <input type="text"
                   placeholder="Voer uw gebruikersnaam in"
                   name="username"
                   value="<?php echo $username ?>"
                   title="Moet minimaal 6 karakters bevatten"
                   >
            *<span class="error"> <?php echo $usernameErr;?></span>
            <ul>
                <li>Minstens 6 karakters</li>
            </ul>
          </div>


        <!-- Register password -->
        <div class="login_containerregister">
            <label><b>Wachtwoord</b></label>
            <input type="password"
                   placeholder="Voer uw wachtwoord in"
                   name="password"
                   value="<?php echo $password ?>"
                   id="password"
                   >
            *<span class="error"> <?php echo $passwordErr;?></span>
        <ul>
          <li>Minstens 8 karakters</li>
        </ul>
        </div>
        <!-- Repeat password -->
        <div class="login_containerregister">
            <label><b>Herhaal wachtwoord</b></label>
            <input type="password"
                   placeholder="Herhaal wachtwoord"
                   name="confirmpassword"
                   value="<?php echo $confirmpassword ?>"
                   id="confirmpassword"
                   title="Herhaal wachtwoord"
                  >
            *<span class="error"> <?php echo $confirmpasswordErr;?></span>
        </div>

        <!-- Register location -->
        <div class="login_containerregister">
            <label><b>Locatie</b></label>
            <input type="text"
                   placeholder="Voer uw woonplaats in"
                   name="location"
                   value="<?php echo $location ?>"
                   pattern="[A-Za-z]{1,}"
                   title="Mag alleen letters bevatten">
            *<span class="error"> <?php echo $locationErr;?></span>
        </div>

        <!-- Register email -->
        <div class="login_containerregister">
            <label><b>Email</b></label>
            <input type="text"
                   placeholder="Voer uw email in"
                   name="email"
                   value="<?php echo $email ?>"
                   id="email"
                   title="Voer een geldige email in">
            *<span class="error"> <?php echo $emailErr;?></span>
        </div>

        <div class="login_containerregister">
             <div class="g-recaptcha" data-sitekey="6Lc72xIUAAAAADumlWetgENm7NGd9Npyo0c_tYYQ"></div>
             <span class="error"> <?php echo $captchaErr;?></span>
        </div>

        <!-- Button for registering -->
        <div class="login_containerlogin">
            <!-- Button for going back to login screen -->
            <a href="https://myhyvesbookplus.nl/login.php" class="button">Annuleren</a>

            <button type="submit"
                   value="Registreer uw account"
                   name="Submit"
                   id="frm1_submit">
            Registreer
            </button>

       </div>
    </form>
</div>
