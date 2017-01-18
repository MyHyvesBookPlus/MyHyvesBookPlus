<div>
    <img style="width:50%;margin-left:25%"
         src="img/top-logo.png"
         alt="MyHyvesbook+">
</div>

<!-- Register Content -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
      return= $correct
      method="post">
    <h2>Registreer uw account</h2>

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
        <span class="error">* <?php echo $nameErr;?></span>
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
        <span class="error">* <?php echo $surnameErr;?></span>
    </div>

    <!-- Register birthday -->
    <div class="login_containerregister">
        <label><b>Geboortedatum</b></label>
        <input type="date"
               name="bday"
               value="<?php echo $bday ?>"
               id="bday"
               placeholder="01/01/1900"
               >
        <span class="error">* <?php echo $bdayErr;?></span>
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
        <span class="error">* <?php echo $usernameErr;?></span>
    </div>

    <ul>
      <li>Minstens 6 karakters</li>
    </ul>

    <!-- Register password -->
    <div class="login_containerregister">
        <label><b>Wachtwoord</b></label>
        <input type="password"
               placeholder="Voer uw wachtwoord in"
               name="password"
               value="<?php echo $password ?>"
               id="password"
               >
        <span class="error">* <?php echo $passwordErr;?></span>
    </div>

    <ul>
      <li>Minstens 8 karakters</li>
    </ul>

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
        <span class="error">* <?php echo $confirmpasswordErr;?></span>
    </div>

    <!-- Register streetname -->
    <div class="login_containerregister">
        <label><b>Straatnaam</b></label>
        <input type="text"
               placeholder="Voer uw straatnaam in"
               name="streetname"
               value="<?php echo $streetname ?>"
               pattern="[A-Za-z]{1,}"
               title="Mag alleen letters bevatten">
        <span class="error">* <?php echo $streetnameErr;?></span>
    </div>

    <!-- Register housenumber -->
    <div class="login_containerregister">
        <label><b>Huisnummer</b></label>
        <input type="text"
               placeholder="Voer uw straatnummer in"
               name="housenumber"
               value="<?php echo $housenumber ?>"
               pattern="[1-9][0-9]{0,}"
               title="Mag alleen nummers bevatten">
        <span class="error">* <?php echo $housenumberErr;?></span>
    </div>

    <!-- Register email -->
    <div class="login_containerregister">
        <label><b>Email</b></label>
        <input type="email"
               placeholder="Voer uw email in"
               name="email"
               value="<?php echo $email ?>"
               id="email"
               title="Voer een geldige email in">
        <span class="error">* <?php echo $emailErr;?></span>
    </div>

    <!-- Button for registering -->
    <div class="login_containerregister">
        <input type="submit"
               value="Registreer uw account"
               name="Submit"
               id="frm1_submit" />
    </div>
</form>

<!-- Button for going back to login screen -->
<div class="login_containerlogin">
    <a href="https://myhyvesbookplus.nl/~joey/public/login.php" class="button">Login met een account</a>
</div>
