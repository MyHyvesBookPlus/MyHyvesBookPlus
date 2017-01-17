<?php
    // define variables and set to empty values
    $name = $surname = $bday = $username = $password = $confirmpassword = $streetname = $housenumber = $email = "";
    $passwordErr = $confirmpasswordErr = "";
    $correct = true;

    if (isset($_POST["name"])) {
      $name = $_POST["name"];
    }

    if (isset($_POST["surname"])) {
      $surname = $_POST["surname"];
    }

    if (isset($_POST["bday"])) {
      $bday = $_POST["bday"];
    }

    if (isset($_POST["username"])) {
      $username = $_POST["username"];
    }

    if (isset($_POST["password"])) {
      $password = $_POST["password"];
    }

    if (isset($_POST["streetname"])) {
      $streetname = $_POST["streetname"];
    }

    if (isset($_POST["housenumber"])) {
      $housenumber = $_POST["housenumber"];
    }

    if (isset($_POST["email"])) {
      $email = $_POST["email"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($_POST["password"]!= $_POST["confirmpassword"]) {
          $passwordErr = "Wachtwoorden matchen niet";
          $confirmpasswordErr = "Wachtwoorden matchen niet";
          $correct = false;
          ?>
          <script>window.onload = function() {
            document.getElementById('id01').style.display='block'
          }</script>
          <?php
      }
    }
?>
<div>
    <img style="width:50%;margin-left:25%"
         src="img/top-logo.png"
         alt="MyHyvesbook+">
</div>

<form action="../profile.php"
      method="post">
    <h1>Welkom bij MyHyvesbook+</h1>

    <div class="login_containerlogin">
        <label><b>Gebruikersnaam</b></label>
        <input type="text"
               placeholder="Voer uw gebruikersnaam in"
               name="uname"
               pattern=".{6,}"
               title="Moet 6 of meer karakters bevatten"
               required>
    </div>

    <div class="login_containerlogin">
        <label><b>Wachtwoord</b></label>
        <input type="password"
               placeholder="Voer uw wachtwoord in"
               name="psw"
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               title="Moet minimaal 1 cijfer, hoofdletter en kleine letter bevatten en minstens 8 karakters lang zijn"
               required>
    </div>

    <div class="login_containerlogin">
        <input type="submit"
               value="Login"
               name="Submit"
               id="frm1_submit" />
    </div>
</form>

<div class="login_containerlogin">
    <button onclick="document.getElementById('id01').style.display='block'">Registreer</button>
</div>

<div class="login_containerregister">
    <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'"
              class="close"
              title="Close Modal">
              &times;</span>

        <!-- Register Content -->
        <form class="modal-content animate"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
              return= $correct
              method="post">
            <h2>Registreer uw account</h2>

            <div class="login_containerregister">
                <label><b>Naam</b></label>
                <input type="text"
                       placeholder="Voer uw naam in"
                       name="name"
                       value="<?php echo $name ?>"
                       pattern="[A-Za-z]{1,}"
                       title="Mag alleen letters bevatten"
                       required>
            </div>

            <div class="login_containerregister">
                <label><b>Achternaam</b></label>
                <input type="text"
                       placeholder="Voer uw achternaam in"
                       name="surname"
                       value="<?php echo $surname ?>"
                       pattern="[A-Za-z]{1,}"
                       title="Mag alleen letters bevatten"
                       required>
            </div>

            <div class="login_containerregister">
                <label><b>Geboortedatum</b></label>
                <input type="date"
                       name="bday"
                       value="<?php echo $bday ?>"
                       id="bday"
                       placeholder="01/01/1900">
            </div>

            <div class="login_containerregister">
                <label><b>Gebruikersnaam</b></label>
                <input type="text"
                       placeholder="Voer uw gebruikersnaam in"
                       name="username"
                       value="<?php echo $username ?>"
                       pattern=".{6,}"
                       title="Moet minstens 6 karakters bevatten"
                       required>
            </div>

            <ul>
              <li>Minstens 6 karakters</li>
            </ul>

            <div class="login_containerregister">
                <label><b>Wachtwoord</b></label>
                <input type="password"
                       placeholder="Voer uw wachtwoord in"
                       name="password"
                       value="<?php echo $password ?>"
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                       id="password"
                       title="Moet minimaal 1 cijfer, hoofdletter en kleine letter bevatten en minstens 8 karakters bevatten"
                       required>
                <span class="error">* <?php echo $passwordErr;?></span>
            </div>

            <ul>
              <li>Minstens 8 karakters</li>
              <li>Minimaal 1 cijfer</li>
              <li>Minimaal 1 hoofdletter</li>
              <li>Minimaal 1 kleine letter</li>
            </ul>

            <div class="login_containerregister">
                <label><b>Herhaal wachtwoord</b></label>
                <input type="password"
                       placeholder="Herhaal wachtwoord"
                       name="confirmpassword"
                       value="<?php echo $confirmpassword ?>"
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                       id="confirmpassword"
                       title="Herhaal wachtwoord"
                       required>
                <span class="error">* <?php echo $confirmpasswordErr;?></span>
            </div>

            <div class="login_containerregister">
                <label><b>Straatnaam</b></label>
                <input type="text"
                       placeholder="Voer uw straatnaam in"
                       name="streetname"
                       value="<?php echo $streetname ?>"
                       pattern="[A-Za-z]{1,}"
                       title="Mag alleen letters bevatten"
                       required>
            </div>

            <div class="login_containerregister">
                <label><b>Huisnummer</b></label>
                <input type="text"
                       placeholder="Voer uw straatnummer in"
                       name="housenumber"
                       value="<?php echo $housenumber ?>"
                       pattern="[1-9][0-9]{0,}"
                       title="Mag alleen nummers bevatten"
                       required>
            </div>

            <div class="login_containerregister">
                <label><b>Email</b></label>
                <input type="email"
                       placeholder="Voer uw email in"
                       name="email"
                       value="<?php echo $email ?>"
                       id="email"
                       title="Voer een geldige email in"
                       required>
            </div>

            <div class="login_containerregister">
                <input type="submit"
                       value="Registreer uw account"
                       name="Submit"
                       id="frm1_submit" />
            </div>
        </form>
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById('id01');
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
}
</script>

<script>
    function passwordfunction() {
        var password1 = document.getElementById("password").value;
        var password2 = document.getElementById("confirmpassword").value;
        var passwordmatching = false;

        if (password1 == password2) {
            document.getElementById("password").style.borderColor = "red";
            document.getElementById("confirmpassword").style.borderColor = "red";
            confirmpassword.setCustomValidity("Wachtwoorden matchen niet")
        } else {
            passwordmatching = true;
        }
        return passwordmatching;
    }
</script>
