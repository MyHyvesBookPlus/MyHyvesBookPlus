<?php
session_start();

// Checks if there's an user already logged in
if(isset($_SESSION["userID"])){
    echo "<script>
                window.onload=checkLoggedIn();
            </script>";
}

// Facebook variables
$appID = "353857824997532";
$appSecret = "db47e91ffbfd355fdd11b4b65eade851";
$fbUsername = $fbPassword = $fbConfirmpassword = $fbName = $fbSurname = $fbBday = $fbEmail = $fbUserID = "";
$fbUsernameErr = $fbPasswordErr = $fbConfirmpasswordErr = $fbEmailErr = $fbBdayErr = "";
$fbCorrect = true;

// Register variables
$name = $surname = $bday = $username = $password = $confirmpassword = $location = $housenumber = $email = $confirmEmail = $captcha = $ip = "";
$genericErr = $nameErr = $surnameErr = $bdayErr = $usernameErr = $passwordErr = $confirmpasswordErr = $locationErr = $housenumberErr = $emailErr = $confirmEmailErr = $captchaErr = "";
$correct = true;

// Bday dates
$day_date = $month_date = $year_date = "";
$fbDay_date = $fbMonth_date = $fbYear_date = "";

// Login variables
$user = $psw = $remember ="";
$loginErr = $resetErr = $fbRegisterErr ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = $_POST["url"];
    // Checks for which button is pressed
    switch ($_POST["submit"]) {
        case "login":
            try {
                $user = ($_POST["user"]);
                validateLogin($_POST["user"], $_POST["psw"], $url);
            } catch(loginException $e) {
                $loginErr = $e->getMessage();
            }
            break;
        case "reset":
            try {
                resetEmail($_POST["forgotEmail"]);
                sendPasswordRecovery($_POST["forgotEmail"]);
            } catch (emailException $e){
                $resetErr = $e->getMessage();
                echo "<script>
                            window.onload = function() {
                              $('#myModal').show();
                            }
                          </script>";
            }
            break;
        case "register":
            include("../views/register.php");
            break;
        case "fbRegister":
            include("../views/fbRegister.php");
            break;
    }
}

// Get facebook information with facebook PHP SDK.
$fb = new Facebook\Facebook([
    'app_id' => $appID,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.2',
]);

// Redirect back to login.php after logging/canceling with facebook.
$redirect = "https://myhyvesbookplus.nl/login.php";
$helper = $fb->getRedirectLoginHelper();

try {
    // Returns a `Facebook\FacebookResponse` object
    $acces_token = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

// If theres no facebook account logged in, ask for permission.
if(!isset($acces_token)){
    $permission=["email", "user_birthday"];
    $loginurl=$helper->getLoginUrl($redirect,$permission);
}else {
    $fb->setDefaultAccessToken($acces_token);
    $response = $fb->get('/me?fields=email,name,birthday');
    $usernode = $response->getGraphUser();

    // Get facebook information
    $nameSplit = explode(" ", $usernode->getName());
    $fbName = $nameSplit[0];
    $fbSurname = $nameSplit[1];
    $fbUserID = $usernode->getID();
    $fbEmail = $usernode->getProperty("email");

    // If there is an account, check if the account is banned or frozen.
    if (fbLogin($fbUserID) == 1) {
        $fbID = getfbUserID($fbUserID)["userID"];
        $fbRole = getfbUserID($fbUserID)["role"];
        if($fbRole == "banned"){
            echo "<script>
                         window.onload=bannedAlert();
                    </script>";

        } else if($fbRole == "frozen"){
            $_SESSION["userID"] = $fbID;
            echo "<script>
                     window.onload=frozenAlert();
                     window.location.href= 'profile.php';
                  </script>";

        } else {
            $_SESSION["userID"] = $fbID;
            header("location: profile.php");

        }
    // Registration with faceobook if theres no account.
    } else {
        echo "<script>
                    window.onload = function() {
                      $('#fbModal').show();
                    }
                  </script>";
    }
}