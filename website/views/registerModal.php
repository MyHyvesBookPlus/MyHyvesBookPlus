<!-- Trigger/Open The Modal -->
<button id="registerBtn" class="button">Registreer een account</button>

<!-- The Modal -->
<div id="registerModal" class="modal">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
          return= $correct
          method="post"
          name="forgotPassword">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3>Registreer uw account</h3>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                      return= $correct
                      method="post">

                    <div class="login_containerregister"><label>U krijgt een bevestigingsemail na het registreren</label></div>

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
                               required
                               autocomplete="given-name">
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
                               required
                               autocomplete="family-name">
                        *<span class="error"> <?php echo $surnameErr;?></span>
                    </div>

                    <!-- Register birthday -->
                    <div class="login_containerregister">
                        <label><b>Geboortedatum</b></label>
                        <?php
                        include("../views/bdayInput.php");
                        ?>
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
                               required>
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
                               required>
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
                               required>
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
                    </div>

                    <!-- Register email -->
                    <div class="login_containerregister">
                        <label><b>Email</b></label>
                        <input type="text"
                               placeholder="Voer uw email in"
                               name="email"
                               value="<?php echo $email ?>"
                               id="email"
                               title="Voer een geldige email in"
                               required>
                        *<span class="error"> <?php echo $emailErr;?></span>
                    </div>

                    <!-- Register email -->
                    <div class="login_containerregister">
                        <label><b>Herhaal email</b></label>
                        <input type="text"
                               placeholder="Herhaal uw email"
                               name="confirmEmail"
                               value="<?php echo $confirmEmail ?>"
                               id="email"
                               title="Herhaal uw email"
                               required>
                        *<span class="error"> <?php echo $confirmEmailErr;?></span>
                    </div>

                    <!-- Captcha confirm -->
                    <div class="login_containerregister">
                        <div class="g-recaptcha" data-sitekey="6Lc72xIUAAAAADumlWetgENm7NGd9Npyo0c_tYYQ">
                        </div>
                        <span class="error"> <?php echo $captchaErr;?></span>
                    </div>

            </div>
            <div class="modal-footer">
                <div class="login_containerfault"><span><?php echo $resetErr; ?></span></div>
                <!-- Register button -->
                <button type="submit"
                        value="register"
                        name="submit"
                        id="frm1_submit">
                    Registreer
                </button>
            </div>
        </div>

    </form>
</div>