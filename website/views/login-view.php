<div class="login_containerNoscript">
    <noscript>
        <a href="http://www.enable-javascript.com/nl/" target="_blank">Om deze site te gebruiken is het noodzakelijk om Javascript aan te zetten.
            Klikt hier voor de instructies om je Javascript te activeren</a>.
    </noscript>
</div>
<div>
    <img style="width:50%;margin-left:25%"
         src="/img/top-logo.png"
         alt="MyHyvesbook+">
</div>
<div class="platform">
    <h1>Welkom bij MyHyvesbook+</h1>
    <!-- Login content  -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
          method="post"
          name="login">

        <!-- Url parameter  -->
        <input type="hidden"
               name="url"
               value="<?php
                        if(isset($_GET["url"])) {
                            echo $_GET["url"];
                        } ?>"/>

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
                    name="submit">
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
        echo '<div class="login_containerlogin"><a class="fbButton" href="' . $loginurl . '"><i class="fa fa-facebook-square"></i> login met Facebook!</a></div>';
    } else {
        echo '<div class="login_containerlogin"><a class="fbButton" href="' . "https://myhyvesbookplus.nl/login.php" . '"><i class="fa fa-facebook-square"></i> loguit Facebook sessie</a></div>';
    }
?>