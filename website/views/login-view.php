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
                   required>
        </div>

        <!-- Login password -->
        <div class="login_containerlogin">
            <label><b>Wachtwoord</b></label>
            <input type="password"
                   class="middle"
                   placeholder="Voer uw wachtwoord in"
                   name="psw"
                   title="Moet minstens 8 karakters lang zijn"
                   required>
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

    </form>
</div>

<!--Vieuws for the modals-->
<div class="login_containerlogin">
    <?php
        include("../views/forgotPasswordModal.php");
        include("../views/registerModal.php");
        include("../views/facebookRegisterModal.php");
    ?>

</div>
<!--Login with facebook button-->
<?php
    if(!isset($acces_token)) {
        echo '<div class="login_containerlogin"><a class="fbButton" href="' . $loginurl . '">login with Facebook!</a></div>';
    }
?>

<script>
// Get the modal
var modal = document.getElementById('myModal');
var registerModal = document.getElementById('registerModal');
var facebookModal = document.getElementById("fbModal");

// Get the button that opens the modal
var registerBtn = document.getElementById("registerBtn");
var btn = document.getElementById("myBtn");


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var registerSpan = document.getElementsByClassName("close")[1];
var facebookCLose = document.getElementsByClassName("close")[2];

    /**
     * When the user clicks the button, open the modal
     */
    btn.onclick = function () {
        modal.style.display = "block";

    }
    registerBtn.onclick = function () {
        registerModal.style.display = "block";
    }

    /**
     * WHen the user clicks on (X), close the modal
     */
    span.onclick = function () {
        modal.style.display = "none";
    }
    registerSpan.onclick = function () {
        registerModal.style.display = "none";
    }
    facebookCLose.onclick = function () {
        facebookModal.style.display = "none";
    }

    /**
     * When the user clicks anywhere outside of the modal, close it
     */
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == registerModal) {
            registerModal.style.display = "none";
        }
        if (event.target == facebookModal) {
            facebookModal.style.display = "none";
        }
    }

    /**
     * When ESC is pressed, close modal
     */
    document.addEventListener('keyup', function(e) {
            if (e.keyCode == 27) {
                modal.style.display = "none";
                registerModal.style.display = "none";
                facebookModal.style.display = "none";

            }
        });

</script>