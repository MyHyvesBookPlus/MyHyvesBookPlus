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
    </form>
</div>

<!-- Button for going to the register screen -->
<div class="login_containerlogin">
    <a href="https://myhyvesbookplus.nl/register" class="button">Registreer een account</a>

    <!-- Trigger/Open The Modal -->
    <button id="myBtn" class="button">Wachtwoord vergeten</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
              return= $correct
              method="post"
              name="forgotPassword">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3>Voer uw emailadres in</h3>
            </div>
            <div class="modal-body">
                <input type="text"
                       placeholder="Voer uw email in"
                       name="forgotEmail"
                       title="Voer een email in">
            </div>
            <div class="modal-footer">
                <div class="login_containerfault"><span><?php echo $resetErr; ?></span></div>
                <button type="submit"
                        value="reset"
                        name="submit"
                        id="frm1_submit">
                    Reset password
                </button>
            </div>
        </div>

        </form>
    </div>

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
                            <!--            <input type="date"-->
                            <!--                   name="bday"-->
                            <!--                   value="--><?php //echo $bday ?><!--"-->
                            <!--                   id="bday"-->
                            <!--                   placeholder="1996/01/01"-->
                            <!--                   data-fv-date-max=""-->
                            <!--                   data-date="" data-date-format="DD MMMM YYYY"-->
                            <!--                   >-->
                            <select name="day_date" >
                                <option>dag</option>
                                <?php
                                for($i=1; $i<32; $i++) {
                                    $i = sprintf("%02d", $i);
                                    ?>
                                    <option value="<?= $i ?>" <?php submitselect($day_date, $i)?>><?= $i ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <select name="month_date">
                                <option>Maand</option>
                                <option value="01" <?php submitselect($month_date, "01")?>>Januari</option>
                                <option value="02" <?php submitselect($month_date, "02")?>>Februari</option>
                                <option value="03" <?php submitselect($month_date, "03")?>>Maart</option>
                                <option value="04" <?php submitselect($month_date, "04")?>>April</option>
                                <option value="05" <?php submitselect($month_date, "05")?>>Mei</option>
                                <option value="06" <?php submitselect($month_date, "06")?>>Juni</option>
                                <option value="07" <?php submitselect($month_date, "07")?>>Juli</option>
                                <option value="08" <?php submitselect($month_date, "08")?>>Augustus</option>
                                <option value="09" <?php submitselect($month_date, "09")?>>September</option>
                                <option value="10" <?php submitselect($month_date, "10")?>>Oktober</option>
                                <option value="11" <?php submitselect($month_date, "11")?>>November</option>
                                <option value="12" <?php submitselect($month_date, "12")?>>December</option>
                            </select>
                            <select name="year_date">
                                <option>Jaar</option>
                                <?php
                                $year = (new DateTime)->format("Y");
                                for($i=$year; $i > $year - 100; $i--) {
                                    ?>
                                    <option value="<?= $i ?>" <?php submitselect($year_date, $i)?>><?= $i ?></option>
                                    <?php
                                }
                                ?>
                            </select>
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

                        <!-- Register email -->
                        <div class="login_containerregister">
                            <label><b>Herhaal email</b></label>
                            <input type="text"
                                   placeholder="Herhaal uw email"
                                   name="confirmEmail"
                                   value="<?php echo $confirmEmail ?>"
                                   id="email"
                                   title="Herhaal uw email">
                            *<span class="error"> <?php echo $confirmEmailErr;?></span>
                        </div>

                        <div class="login_containerregister">
                            <div class="g-recaptcha" data-sitekey="6Lc72xIUAAAAADumlWetgENm7NGd9Npyo0c_tYYQ"></div>
                            <span class="error"> <?php echo $captchaErr;?></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <div class="login_containerfault"><span><?php echo $resetErr; ?></span></div>
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
    btn.onclick = function() {
        modal.style.display = "block";
    }
    registerBtn.onclick = function() {
        registerModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    registerSpan.onclick = function() {
        registerModal.style.display = "none";
    }
</script>
