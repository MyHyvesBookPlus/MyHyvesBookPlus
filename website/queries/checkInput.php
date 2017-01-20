<?php
/**
 * Function for checking inputfields
 * @param variable $variable Give name of the inputfield.
 * @param string $option Give the name of the option.
 * @return sets correct to false and gives value to error message if it doesn't pass the checks.
 */
function checkInputChoice($variable, $option){
    if (empty($_POST[$variable])) {
        $GLOBALS[$variable . "Err"] = "Verplicht!";
        $GLOBALS["correct"] = false;

    } else {
        $GLOBALS[$variable] = test_input($_POST[$variable]);
        switch ($option) {
          case "lettersAndSpace":
            checkonly($variable);
            break;

          case "username";
            username($variable);
            break;

          case "longerEight";
            longerEigth($variable);
            break;

          case "email";
            validateEmail($variable);
            break;

          default:
            break;
        }
    }
}

/* Checks for only letters and spaces. */
function checkOnly($variable){
    if (!preg_match("/^[a-zA-Z ]*$/",$GLOBALS[$variable])) {
        $GLOBALS[$variable . "Err"] = "Alleen letters en spaties zijn toegestaan!";
        $correct = false;
    }
}
/* checks if username exist and if its longer than 6 characters. */
function username($variable){
    if (strlen($GLOBALS[$variable]) < 6) {
        $GLOBALS[$variable . "Err"] = "Gebruikersnaam moet minstens 6 karakters bevatten";
        $correct = false;
    } else if (getExistingUsername() == 1) {
        $GLOBALS[$variable . "Err"] = "Gebruikersnaam bestaat al";
        $correct = false;
    }
}

/* checks if an input is longer that 8 characters. */
function longerEight($variable){
    if (strlen($GLOBALS[$variable]) < 8) {
        $GLOBALS[$variable . "Err"] = "Moet minstens 8 karakters bevatten";
        $correct = false;
    }
}

/* checks if an input is a valid email. */
function validateEmail($variable){
    if (!filter_var($GLOBALS[$variable], FILTER_VALIDATE_EMAIL)) {
        $GLOBALS[$variable . "Err"] = "Geldige email invullen!";
        $correct = false;

    } else if (getExistingEmail() == 1){
        $GLOBALS[$variable . "Err"] = "Email bestaat al";
        $correct = false;

    }
}

/* checks if two passwords matches. */
function matchPassword(){
    if ($_POST["password"] != $_POST["confirmpassword"]) {
        $GLOBALS["confirmpasswordErr"] = "Wachtwoorden matchen niet";
        $GLOBALS["correct"]  = false;

    }
}

// Checks if everything is filled in correctly
function registerCheck(){
    if ($GLOBALS["correct"] == false){
        $GLOBALS["genericErr"] = "Bepaalde velden zijn verkeerd of niet ingevuld!";

    } else {
        registerAccount();
        header("location: login.php");

    }
}

/* removes weird characters of an input. */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
