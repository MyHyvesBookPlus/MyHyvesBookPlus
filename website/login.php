<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles/index.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    		<script src="js/dobPicker.min.js"></script>
        <meta charset="utf-8">
        <title>MyHyvesbook+</title>
    </head>
    <body>
        <div>
            <img style="width:50%;margin-left:25%" src="img/top-logo.png" alt="MyHyvesbook+">
        </div>

        <form action="../profile.php" method="post">
            <h1>Welkom bij MyHyvesbook+</h1>
            <div class="login_containerlogin">
                <label><b>Gebruikersnaam</b></label>
                <input type="text" placeholder="Voer uw gebruikersnaam in" name="uname"
                pattern=".{6,}" title="Moet 6 of meer karakters bevatten" required>
            </div>

            <div class="login_containerlogin">
                <label><b>Wachtwoord</b></label>
                <input type="password" placeholder="Voer uw wachtwoord in" name="psw"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                title="Moet minimaal 1 cijfer, hoofdletter en kleine letter bevatten en minstens 8 karakters lang zijn" required>
            </div>

            <div class="login_containerlogin">
                <input type="submit" value="Login" name="Submit" id="frm1_submit" />
            </div>
        </form>

        <div class="login_containerlogin">
            <button onclick="document.getElementById('id01').style.display='block'">Registreer</button>
        </div>

        <div class="login_containerregister">
            <div id="id01" class="modal">
                <span onclick="document.getElementById('id01').style.display='none'"
                class="close" title="Close Modal">&times;</span>

                <!-- Register Content -->
                <form class="modal-content animate" action="../profile.php" onsubmit="return passwordfunction()" method="post">
                    <h2>Registreer uw account</h2>

                    <div class="login_containerregister">
                        <label><b>Naam</b></label>
                        <input type="text" placeholder="Voer uw naam in" name="name"
                        pattern="[A-Za-z]{1,}" title="Mag alleen letters bevatten" required>
                    </div>

                    <div class="login_containerregister">
                        <label><b>Achternaam</b></label>
                        <input type="text" placeholder="Voer uw achternaam in" name="surname"
                        pattern="[A-Za-z]{1,}" title="Mag alleen letters bevatten" required>
                    </div>

                    <div class="login_containerregister">
                        <label><b>Geboortedatum</b></label>
                        <!-- These are the select elements we will target -->
                    		<select id="dobday" title="Voer een dag in" ></select>
                    		<select id="dobmonth" title="Voer een maand in" required></select>
                    		<select id="dobyear" title="Voer een jaar in" required></select>
                    		<!-- And here's the library being called! -->
                    		<script>
                    			$(document).ready(function() {
                        				$.dobPicker({
                          					daySelector: '#dobday',
                          					monthSelector: '#dobmonth',
                          					yearSelector: '#dobyear',
                          					dayDefault: 'Dag',
                          					monthDefault: 'Maand',
                          					yearDefault: 'Jaar',
                          					minimumAge: 12,
                          					maximumAge: 80
                        				});
                      			});
                    		</script>
                    </div>

                    <div class="login_containerregister">
                        <label><b>Gebruikersnaam</b></label>
                        <input type="text" placeholder="Voer uw gebruikersnaam in" name="username"
                        pattern=".{6,}" title="Moet minstens 6 karakters bevatten" required>
                    </div>

                    <div class="login_containerregister">
                        <label><b>Wachtwoord</b></label>
                        <input type="password" placeholder="Voer uw wachtwoord in" name="password"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="password"
                        title="Moet minimaal 1 cijfer, hoofdletter en kleine letter bevatten en minstens 8 karakters bevatten" required>
                    </div>

                    <div class="login_containerregister">
                        <label><b>Herhaal wachtwoord</b></label>
                        <input type="password" placeholder="Herhaal wachtwoord" name="confirmpassword"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="confirmpassword"
                        title="Herhaal wachtwoord" required>
                    </div>

                    <div class="login_containerregister">
                        <label><b>Straatnaam</b></label>
                        <input type="text" placeholder="Voer uw straatnaam in" name="name"
                        pattern="[A-Za-z]{1,}" title="Mag alleen letters bevatten" required>
                    </div>

                    <div class="login_containerregister">
                        <label><b>Straatnummer</b></label>
                        <input type="text" placeholder="Voer uw straatnummer in" name="name"
                        pattern="[1-9][0-9]{0,}" title="Mag alleen nummers bevatten" required>
                    </div>

                    <div class="login_containerregister">
                        <label><b>Email</b></label>
                        <input type="email" placeholder="Voer uw email in" id="email"
                        title="Voer een geldige email in" required>
                    </div>

                    <div class="login_containerregister">
                        <input type="submit" value="Registreer uw account" name="Submit" id="frm1_submit" />
                    </div>
                </form>
            </div>
        </div>
        <script>
        $("#default-settings").birthdayPicker();
        </script>
    </body>
</html>

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
        var passwordmatching = true;

        if (password1 != password2) {
            document.getElementById("password").style.borderColor = "red";
            document.getElementById("confirmpassword").style.borderColor = "red";
            passwordmatching = false;
            confirmpassword.setCustomValidity("Wachtwoorden matchen niet")
        }
        return passwordmatching;
    }
</script>
