<?php

    try {
        $name = test_input(($_POST["name"]));
        checkInputChoice($name, "lettersAndSpaces");
    } catch(lettersAndSpacesException $e){
        $correct = false;
        $nameErr = $e->getMessage();
    }

    try {
        $surname = test_input(($_POST["surname"]));
        checkInputChoice($surname, "lettersAndSpaces");
    }
    catch(lettersAndSpacesException $e){
        $correct = false;
        $surnameErr = $e->getMessage();
    }

    try{
        $day_date = test_input(($_POST["day_date"]));
        $month_date = test_input(($_POST["month_date"]));
        $year_date = test_input(($_POST["year_date"]));
        $bday = $year_date . "-" . $month_date . "-" . $day_date;
        checkInputChoice($bday, "bday");
    } catch(bdayException $e){
        $correct = false;
        $bdayErr = $e->getMessage();
    }

    try{
        $username = str_replace(' ', '', test_input(($_POST["username"])));
        checkInputChoice($username, "username");
    } catch(usernameException $e){
        $correct = false;
        $usernameErr = $e->getMessage();
    }

    try{
        $password = str_replace(' ', '', test_input(($_POST["password"])));
        checkInputChoice($password, "longerEight");
        matchPassword();
    } catch(passwordException $e){
        $correct = false;
        $passwordErr = $e->getMessage();
    } catch(confirmPasswordException $e){
        $correct = false;
        $confirmPasswordErr = $e->getMessage();
    }

    try{
        $location = test_input(($_POST["location"]));
        checkInputChoice($location, "");
    } catch(lettersAndSpacesException $e){
        $correct = false;
        $locationErr = $e->getMessage();
    }

    try{
        $email = test_input(($_POST["email"]));
        checkInputChoice($email, "email");
        $confirmEmail = test_input(($_POST["confirmEmail"]));
        matchEmail();
    } catch(emailException $e){
        $correct = false;
        $emailErr = $e->getMessage();
    } catch(confirmEmailException $e){
        $correct = false;
        $confirmEmailErr = $e->getMessage();
    }

    try{
        $captcha = $_POST['g-recaptcha-response'];
        checkCaptcha($captcha);
    } catch(captchaException $e){
        $correct = false;
        $captchaErr = $e->getMessage();
    }

    try {
        getIp();
        registerCheck($correct);
        sendConfirmEmail(getUserID()["userID"]);
    } catch(registerException $e){
        echo "<script>
                window.onload = function() {
                  $('#registerModal').show();
                }
              </script>";
        $genericErr = $e->getMessage();
    }
