<div>
    <img style="width:50%;margin-left:25%"
         src="/img/top-logo.png"
         alt="MyHyvesbook+">
</div>
<div class="platform">
    <h1>Welkom bij MyHyvesbook+</h1>
    <!-- Login content  -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
          return=$correct
          method="post"
          name="login">

        <!-- Login name -->
        <div class="login_containerlogin">
            <label><b>Gebruikersnaam/Email</b></label>
            <input type="text"
                   class="middle"
                   placeholder="Voer uw gebruikersnaam/email in"
                   name="user"
                   value="<?php echo $user ?>"
                   title="Moet een geldige gebruiker zijn"
                   >
        </div>

        <!-- Login password -->
        <div class="login_containerlogin">
            <label><b>Wachtwoord</b></label>
            <input type="password"
                   class="middle"
                   placeholder="Voer uw wachtwoord in"
                   name="psw"
                   title="Moet minstens 8 karakters lang zijn"
                   >
        </div>

        <!-- Error message -->
        <div class="login_containerfault"><span><?php echo $loginErr; ?></span></div>

        <!-- Button for logging in -->
        <div class="login_containerlogin">
            <button type="submit"
                    value="login"
                    name="submit"
                    id="frm1_submit">
            Inloggen
            </button>
        </div>

        <div class="login_containerlogin">
            <label><b>Onthoud mij</b></label>
            <input type="checkbox" name="rememberMe" value=1><br>
        </div>
    </form>
</div>

<!-- Button for going to the register screen -->
<div class="login_containerlogin">
<!--    <a href="https://myhyvesbookplus.nl/register" class="button">Registreer een account</a>-->

    <?php
        include("../views/forgotPasswordModal.php");
        include("../views/registerModal.php");
    ?>

        <!--
      Below we include the Login Button social plugin. This button uses
      the JavaScript SDK to present a graphical Login button that triggers
      the FB.login() function when clicked.
    -->
<!--    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>-->
<!---->
<!---->
<!--    <span id="fbLogout" onclick="fbLogout()"><a class="fb_button fb_button_medium"><span class="fb_button_text">Logout</span></a></span>-->

    <fb:login-button autologoutlink="true"></fb:login-button>


    <div id="status">
    </div>
</div>

<script>
// Get the button that opens the modal
var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");

// Get the modal
var registerModal = document.getElementById('registerModal');
var registerBtn = document.getElementById("registerBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var registerSpan = document.getElementsByClassName("close")[1];

// When the user clicks the button, open the modal
    btn.onclick = function () {
//        modal.style.display = "block";
        modal.style.display = "block";
        window.onload=emailSent();

    }

    registerBtn.onclick = function () {
        registerModal.style.display = "block";
    }

// When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }
    registerSpan.onclick = function () {
        registerModal.style.display = "none";
    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == registerModal) {
            registerModal.style.display = "none";
        }
    }
</script>