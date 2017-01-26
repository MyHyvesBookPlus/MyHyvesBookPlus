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
    </div>
<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
