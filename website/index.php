<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="index.css">
    <meta charset="utf-8">
    <title>MyHyvesbook+</title>
  </head>
  <body>
    <div>
      <img style="width:50%;margin-left:25%" src="Logo.png" alt="MyHyvesbook+">
    </div>

    <form action="../~lars/" method="post">
      <h1>Welkom bij MyHyvesbook+</h1>
      <div class="containercenter">
        <label><b>Gebruikersnaam</b></label>
        <input type="text" placeholder="Voer je gebruikersnaam in" name="uname"
        pattern=".{6,}" title="Moet zes of meer karakters zijn" required>
      </div>

      <div class="containercenter">
        <label><b>Wachtwoord</b></label>
        <input type="password" placeholder="Voer je wachtwoord in" name="psw"
        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
        title="Moet miniaal 1 cijfer, 1 hoofdletter en kleine letter hebben en minstens 8 of meer karakters zijn" required>
      </div>

      <div class="containercenter">
        <input type="submit" value="Login" name="Submit" id="frm1_submit" />
      </div>
    </form>

    <div class="containercenter">
      <button onclick="document.getElementById('id01').style.display='block'">Registreer</button>
    </div>

    <div class="container">
      <div id="id01" class="modal">
      <span onclick="document.getElementById('id01').style.display='none'"
      class="close" title="Close Modal">&times;</span>

      <!-- Register Content -->
        <form class="modal-content animate" action="../~lars/" onsubmit="return passwordfunction()" method="post">
          <h2>Registreer je account</h2>

          <div class="container">
            <label><b>Naam</b></label>
            <input type="text" placeholder="Voer je naam in" name="name"
            pattern="[A-Za-z]{1,}" title="Moet alleen letters zijn" required>
          </div>

          <div class="container">
            <label><b>Achternaam</b></label>
            <input type="text" placeholder="Voer je achternaam in" name="surname"
            pattern="[A-Za-z]{1,}" title="Moet alleen letters zijn" required>
          </div>

          <div class="container">
            <label><b>Gebruikersnaam</b></label>
            <input type="text" placeholder="Voer je gebruikersnaam in" name="username"
            pattern=".{6,}" title="Moet meer dan 6 karakers zijn" required>
          </div>

          <div class="container">
            <label><b>Wachtwoord</b></label>
            <input type="password" placeholder="Voer je wachtwoord in" name="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="password"
            title="Moet miniaal 1 cijfer, 1 hoofdletter en kleine letter hebben en minstens 8 of meer karakters zijn" required>
          </div>

          <div class="container">
            <label><b>Herhaal wachtwoord</b></label>
            <input type="password" placeholder="Herhaal wachtwoord"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="confirmpassword"
            title="Wachtwoord matchen niet" required>
          </div>

          <div class="container">
            <label><b>Straatnaam</b></label>
            <input type="text" placeholder="Voer jouw straatnaam in" name="name"
            pattern="[A-Za-z]{1,}" title="Moet alleen letters zijn" required>
          </div>

          <div class="container">
            <label><b>Straatnummer</b></label>
            <input type="text" placeholder="Voer jouw straatnummer in" name="name"
            pattern="[1-9][0-9]{0,}" title="Moet alleen nummers zijn" required>
          </div>

          <div class="container">
            <label><b>Email</b></label>
            <input type="email" placeholder="Voer je email in" title="Voer een geldige email in">
          <div class="container">
            <input type="submit" value="Registreer je account" name="Submit" id="frm1_submit" />
          </div>
        </form>

      </div>
    </div>
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
    var matching = true;
    if (password1 != password2) {
        document.getElementById("password").style.borderColor = "red";;
        document.getElementById("confirmpassword").style.borderColor = "red";;
        ok = false;
        confirmpassword.setCustomValidity("Wachwoord match niet")
    }
    return matching;
}
</script>
