<!DOCTYPE html>
<html>
<?php
    include("../views/login_head.php");
    require_once("../queries/connect.php");
    include_once("../queries/login.php");
    include_once("../queries/checkInput.php");
    include_once("../queries/emailconfirm.php");
    include_once("../queries/requestpassword.php");
    include_once("../queries/register.php");
    require_once("../queries/Facebook/autoload.php");

?>
<body>
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
    $fbUsername = $fbPassword = $fbConfirmpassword = "";
    $fbUsernameErr = $fbPasswordErr = $fbConfirmpasswordErr = $fbEmailErr = $fbBdayErr = "";
    $fbCorrect = true;
    $fbName = $fbSurname = $fbBday = $fbEmail = "";
    $bdayExist = false;

    // Register variables
    $name = $surname = $bday = $username = $password = $confirmpassword = $location = $housenumber = $email = $confirmEmail = $captcha = $ip = "";
    $genericErr = $nameErr = $surnameErr = $bdayErr = $usernameErr = $passwordErr = $confirmpasswordErr = $locationErr = $housenumberErr = $emailErr = $confirmEmailErr = $captchaErr = "";
    $correct = true;

    $day_date = $month_date = $year_date = "";
    $fbDay_date = $fbMonth_date = $fbYear_date = "";

// Login variables
    $user = $psw = $remember ="";
    $loginErr = $resetErr = $fbRegisterErr ="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Checks for which button is pressed
        switch ($_POST["submit"]) {
            case "login":
                try {
                    $user = ($_POST["user"]);
                    validateLogin($_POST["user"], $_POST["psw"]);
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
                include("register.php");
                break;
            case "fbRegister":
                include("fbRegister.php");
                break;
        }
    }
    $fb = new Facebook\Facebook([
        'app_id' => $appID,
        'app_secret' => $appSecret,
        'default_graph_version' => 'v2.2',
    ]);
    $redirect = "https://myhyvesbookplus.nl/~joey/login.php";
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

    if(!isset($acces_token)){
        $permission=["email", "user_birthday"];
        $loginurl=$helper->getLoginUrl($redirect,$permission);
    }else {
        $fb->setDefaultAccessToken($acces_token);
        $response = $fb->get('/me?fields=email,name,birthday');
        $usernode = $response->getGraphUser();

//        echo $usernode->getName() . "</br>";
//        echo $usernode->getId() . "</br>";
//        echo $usernode->getProperty("email") . "<br><br>";
//        echo "Picture<br>";
//        echo "<img src='$image' /><br><br>";

        $nameSplit = explode(" ", $usernode->getName());
        $fbName = $nameSplit[0];
        $fbSurname = $nameSplit[1];
        $fbEmail = $usernode->getProperty("email");
        $image = 'https://graph.facebook.com/' . $usernode->getId() . '/picture?width=200';


        if (fbLogin($fbEmail) == 1) {
            $fbUserID = getfbUserID($fbEmail)["userID"];
            $fbRole = getfbUserID($fbEmail)["role"];
            if($fbRole == "banned"){
                echo "<script>
                         window.onload=bannedAlert();
                    </script>";
            } else if($fbRole == "frozen"){
                $_SESSION["userID"] = $fbUserID;
                echo "<script>
                         window.onload=frozenAlert();
                         window.location.href= 'profile.php';
                    </script>";
            } else {
                $_SESSION["userID"] = $fbUserID;
                header("location: profile.php");
            }
        } else {
            echo "<script>
                    window.onload = function() {
                      $('#fbModal').show();
                    }
                  </script>";
        }
    }
/* This view adds login view */
include("../views/login-view.php");
?>
</body>
</html>
