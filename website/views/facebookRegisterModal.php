<!-- The Modal -->
<div id="fbModal" class="modal">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
          method="post"
          name="fbModal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3>Voer uw gegevens in</h3>
            </div>
            <div class="modal-body">
                <div class="login_containerfault"><span><?php echo $fbRegisterErr; ?></span></div>
                <div class="login_containerfault"><span><?php echo $fbEmailErr; ?></span></div>
                <!-- Register username -->
                <div class="login_containerregister">
                    <label><b>Gebruikersnaam</b></label>
                    <input type="text"
                           placeholder="Voer uw gebruikersnaam in"
                           name="fbUsername"
                           value="<?php echo $fbUsername ?>"
                           title="Moet minimaal 6 karakters bevatten"
                           required>
                    *<span class="error"> <?php echo $fbUsernameErr;?></span>
                    <ul>
                        <li>Minstens 6 karakters</li>
                    </ul>
                </div>

                <!-- Register password -->
                <div class="login_containerregister">
                    <label><b>Wachtwoord</b></label>
                    <input type="password"
                           placeholder="Voer uw wachtwoord in"
                           name="fbPassword"
                           value="<?php echo $fbPassword ?>"
                           id="password"
                           required>
                    *<span class="error"> <?php echo $fbPasswordErr;?></span>
                    <ul>
                        <li>Minstens 8 karakters</li>
                    </ul>
                </div>
                <!-- Repeat password -->
                <div class="login_containerregister">
                    <label><b>Herhaal wachtwoord</b></label>
                    <input type="password"
                           placeholder="Herhaal wachtwoord"
                           name="fbConfirmpassword"
                           value="<?php echo $fbConfirmpassword ?>"
                           id="confirmpassword"
                           title="Herhaal wachtwoord">
                    *<span class="error"> <?php echo $fbConfirmpasswordErr;?></span>
                </div>

                <?php if(empty($userBday)) { ?>
                <!-- Register birthday -->
                <div class="login_containerregister">
                    <label><b>Geboortedatum</b></label>
                    <?php
                    include("../views/fbBdayInput.php");
                    ?>
                    *<span class="error"> <?php echo $fbBdayErr;?></span>
                </div>
                <?php } ?>
            </div>
            <span class="error"> <?php echo $fbEmailErr;?></span>
            <div class="modal-footer">
                <button type="submit"
                        value="fbRegister"
                        name="submit">
                    Registreer account
                </button>
            </div>
        </div>
        <!-- Facebook information-->
        <input type="hidden"
               name="fbName"
               value="<?php echo $fbName ?>">
        <input type="hidden"
               name="fbSurname"
               value="<?php echo $fbSurname ?>">
        <input type="hidden"
               name="fbUserID"
               value="<?php echo $fbUserID ?>">
        <input type="hidden"
               name="fbEmail"
               value="<?php echo $fbEmail ?>">
    </form>
</div>