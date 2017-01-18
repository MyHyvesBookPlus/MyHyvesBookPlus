<div>
    <img style="width:50%;margin-left:25%"
         src="img/top-logo.png"
         alt="MyHyvesbook+">
</div>

<!-- Login content  -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
      return= $correct
      method="post">
    <h1>Welkom bij MyHyvesbook+</h1>

    <!-- Login name -->
    <div class="login_containerlogin">
        <label><b>Gebruikersnaam</b></label>
        <input type="text"
               placeholder="Voer uw gebruikersnaam in"
               name="uname"
               value="<?php echo $uname ?>"
               title="Moet 6 of meer karakters bevatten"
               >
    </div>

    <!-- Login password -->
    <div class="login_containerlogin">
        <label><b>Wachtwoord</b></label>
        <input type="password"
               placeholder="Voer uw wachtwoord in"
               name="psw"
               title="Moet minimaal 1 cijfer, hoofdletter en kleine letter bevatten en minstens 8 karakters lang zijn"
               >
    </div>

    <!-- Error message -->
    <div class="login_containerfault"><span><?php echo $loginErr; ?></span></div>

    <!-- Button for logging in -->
    <div class="login_containerlogin">
        <input type="submit"
               value="Login"
               name="submit"
               id="frm1_submit" />
    </div>
</form>

<!-- Button for going to the register screen -->
<div class="login_containerlogin">
    <a href="https://myhyvesbookplus.nl/~joey/public/register.php" class="button">Registreer een account</a>
</div>