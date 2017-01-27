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
?>
<body>
<script>
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
            // Logged into your app and Facebook.
            testAPI();
        } else if (response.status === 'not_authorized') {
            // The person is logged into Facebook, but not your app.
            document.getElementById('status').innerHTML = 'Please log ' +
                'into this app.';
        } else {
            // The person is not logged into Facebook, so we're not sure if
            // they are logged into this app or not.
            document.getElementById('status').innerHTML = 'Please log ' +
                'into Facebook.';
        }
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId      : '353857824997532',
            cookie     : true,
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();

        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });

    };

    function fbLogout() {
        FB.logout(function (response) {
            //Do what ever you want here when logged out like reloading the page
            window.location.reload();
        });
    }
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
            console.log('Successful login for: ' + response.name);
            document.getElementById('status').innerHTML =
                'Thanks for logging in, ' + response.name +  +'!';
//                alert("You are logged in with facebook");

        });
    }
</script>
<?php
    session_start();

    if(isset($_SESSION["userID"])){
      echo "<script>
                window.onload=checkLoggedIn();
            </script>";
    }

    // define variables and set to empty values
    $name = $surname = $bday = $username = $password = $confirmpassword = $location = $housenumber = $email = $confirmEmail = $captcha = $ip = "";
    $genericErr = $nameErr = $surnameErr = $bdayErr = $usernameErr = $passwordErr = $confirmpasswordErr = $locationErr = $housenumberErr = $emailErr = $confirmEmailErr = $captchaErr = "";
    $correct = true;
    $day_date = "dag";
    $month_date = "maand";
    $year_date = "jaar";

    // Define variables and set to empty values
    $user = $psw = $remember ="";
    $loginErr = $resetErr ="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        }
    }
/* This view adds login view */
include("../views/login-view.php");
?>
</body>
</html>
