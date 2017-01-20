<!DOCTYPE html>
<html>
<?php
    include("../views/login_head.php");
    require_once("../queries/connect.php");
    include_once("../queries/login.php");
    include_once("../queries/checkInput.php")
?>
<body>
<?php
    session_start();

    if(isset($_SESSION["userID"])){
      <script>
       window.onload=checkLoggedIn();
      </script>
    }

    // Define variables and set to empty values
    $uname = $psw ="";
    $loginErr ="";

    // Trying to login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Empty username or password field
        if (empty($_POST["uname"]) || empty($_POST["psw"])) {
            $loginErr = "Gebruikersnaam of wachtwoord is niet ingevuld";

        }
        else {
            $uname = strtolower(test_input($_POST["uname"]));
            $psw = test_input($_POST["psw"]);
            $hash = getUser()["password"];
            $userid = getUser()["userID"];

            // If there's an account, go to the profile page
            if(password_verify($psw, $hash)) {
               $_SESSION["userID"] = $userid;
               header("location: profile.php");

            } else {
               $loginErr = "Inloggegevens zijn niet correct";
            }

        }
    }

/* This view adds login view */
include("../views/login-view.php");
?>

<script>
function checkLoggedIn() {
    if (confirm("You are already logged in!\Do you want to logout?\Press ok to logout.") == true) {
        unset($_SESSION["userID"]);
        header("Location: login.php");
    } else {
        header("location: profile.php");
    }
    document.getElementById("demo").innerHTML = x;
}
</script>

</body>
</html>
