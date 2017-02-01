<?php
try{
    $fbUsername = str_replace(' ', '', test_input(($_POST["fbUsername"])));
    checkInputChoice($fbUsername, "fbUsername");
} catch(usernameException $e){
    $fbCorrect = false;
    $fbUsernameErr = $e->getMessage();
}

try{
    $fbPassword = str_replace(' ', '', test_input(($_POST["fbPassword"])));
    checkInputChoice($fbPassword, "longerEight");
    matchfbPassword();
} catch(passwordException $e){
    $fbCorrect = false;
    $fbPasswordErr = $e->getMessage();
} catch(fbConfirmPasswordException $e){
    $fbCorrect = false;
    $fbConfirmpasswordErr = $e->getMessage();
}

try{
    $fbName = test_input(($_POST["fbName"]));
    checkInputChoice($fbName, "lettersAndSpaces");
} catch(lettersAndSpacesException $e){
    $fbCorrect = false;
}

try {
    $fbSurname = test_input(($_POST["fbSurname"]));
    checkInputChoice($fbSurname, "lettersAndSpaces");
}
catch(lettersAndSpacesException $e){
    $fbCorrect = false;
}

try {
    $fbDay_date = test_input(($_POST["fbDay_date"]));
    $fbMonth_date = test_input(($_POST["fbMonth_date"]));
    $fbYear_date = test_input(($_POST["fbYear_date"]));
    $fbBday = $fbYear_date . "-" . $fbMonth_date . "-" . $fbDay_date;
    checkInputChoice($fbBday, "bday");
} catch (bdayException $e) {
    $fbBdayErr = $e->getMessage();
    $fbCorrect = false;
}

try{
    $fbEmail = test_input(($_POST["fbEmail"]));
    checkInputChoice($fbEmail, "fbEmail");
} catch(emailException $e){
    $fbCorrect = false;
    $fbEmailErr = $e->getMessage();

}

$fbUserID = test_input(($_POST["fbUserID"]));

try {
    fbRegisterCheck($fbCorrect);
} catch(registerException $e){
    echo "<script>
                window.onload = function() {
                  $('#fbModal').show();
                }
              </script>";
    $fbRegisterErr = $e->getMessage();
}