<!DOCTYPE html>
<html>
<?php
include("../views/login_head.php");
?>
<body>
<?php
    session_start();

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
            $uname=$_POST["uname"];
            $psw=$_POST["psw"];

            // Protection against MySQL injections
            $uname = stripslashes($uname);
            $psw = stripslashes($psw);
            $uname = mysql_real_escape_string($uname);
            $psw = mysql_real_escape_string($psw);

            // Database information
            $servername = "agile136.science.uva.nl";
            $username = "mhbp";
            $password = "qdtboXhCHJyL2szC";

            // Creates connection
            $conn = new mysqli($servername, $username, $password);

            // Selects database
            $db = mysql_select_db("company", $connection);

            // Query for listing all accounts that meets the requirement of the login information
            $query = mysql_query("select * from login where password='$psw' AND username='$uname'", $connection);

            // Checks if there's an account
            $count = mysql_num_rows($query);

            // If there's an account, go to the profile page
            if($count == 1) {
               $_SESSION[$uname] = $uname;
               $_SESSION[$userID] = $userID;

               header("location: myhyvesbookplus.nl/profile.php");
            }else {
               $loginErr = "Inloggegevens zijn niet correct";
            }

            // Closing Connection
            mysql_close($connection);
        }
    }



/* This view adds login view */
include("../views/login-view.php");
?>
</body>
</html>
