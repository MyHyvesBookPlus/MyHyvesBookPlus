<?php
/**
 * Function for checking inputfields
 * @param String $variable Give name of the inputfield.
 * @param String $option Give the name of the option.
 * @return sets correct to false and gives value to error message if it doesn't pass the checks.
 */
function checkInputChoice($variable, $option){
    switch ($option) {
      case "lettersAndSpaces";
        checkName($variable);
        break;

      case "bday";
        validateBday($variable);
        break;

      case "username";
        username($variable);
        break;

      case "fbUsername";
        fbUsername($variable);
        break;

      case "longerEight";
        longerEight($variable);
        break;

      case "email";
        validateEmail($variable);
        break;

      case "fbEmail";
        validateFBEmail($variable);
        break;

      default:
        break;

    }
}

/* Checks for only letters and spaces. */
function checkName($variable){
    if (empty($variable)) {
        throw new lettersAndSpacesException("Verplicht!");
    } else if (!preg_match("/^[a-zA-Z ]*$/", $variable)) {
        throw new lettersAndSpacesException("Alleen letters en spaties zijn toegestaan!");
    }
}

/* Checks for bday */
function validateBday($variable){
    if (empty($variable)) {
        throw new bdayException("Verplicht!");
    } else {
        if (!(validateDate($variable, "Y-m-d"))) {
            throw new bdayException("Geen geldige datum");
        } else {
            $dateNow = date("Y-m-d");
            if ($dateNow < $variable) {
                throw new bdayException("Geen geldige datum!");
            }
        }
    }
}

// Checks for date
function validateDate($date, $format)
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/* checks if username exist and if its longer than 6 characters. */
function username($variable){
    if (empty($variable)) {
        throw new usernameException("Verplicht!");
    } else if (strlen($variable) < 6) {
        throw new usernameException("Moet minstens 6 karakters bevatten");
    } else if (getExistingUsername() == 1) {
        throw new usernameException("Gebruikersnaam bestaal al");
    }
}

/* checks if username exist and if its longer than 6 characters. */
function fbUsername($variable){
    if (empty($variable)) {
        throw new usernameException("Verplicht!");
    } else if (strlen($variable) < 6) {
        throw new usernameException("Moet minstens 6 karakters bevatten");
    } else if (getExistingFBUsername() == 1) {
        throw new usernameException("Gebruikersnaam bestaal al");
    }
}

/* checks if an input is longer that 8 characters. */
function longerEight($variable){
    if (empty($variable)) {
        throw new passwordException("Verplicht!");
    } else if (strlen($variable) < 8) {
        throw new passwordException("Moet minstens 8 karakters bevatten");
    }
}

/* checks if an input is a valid email. */
function validateEmail($variable){
    if (empty($variable)) {
        throw new emailException("Verplicht!");
    } else if (!filter_var($variable, FILTER_VALIDATE_EMAIL)) {
        throw new emailException("Geldige email invullen");
    } else if (getExistingEmail() == 1){
        throw new emailException("Email bestaal al!");
    }
}

/* checks if an input is a valid email. */
function validateFBEmail($variable){
    if (empty($variable)) {
        throw new emailException("Verplicht!");
    } else if (!filter_var($variable, FILTER_VALIDATE_EMAIL)) {
        throw new emailException("Geldige email invullen");
    } else if (getExistingFBEmail() == 1){
        throw new emailException("Email bestaal al!");
    }
}

function matchEmail(){
    if (strtolower($_POST["email"]) != strtolower($_POST["confirmEmail"])){
        throw new confirmEmailException("Emails matchen niet!");
    }
}

/* checks if an input is a valid email. */
function resetEmail($variable){
    if (empty($variable)) {
        throw new emailException("Verplicht!");
    } else if (!filter_var($variable, FILTER_VALIDATE_EMAIL)) {
        throw new emailException("Geldige email invullen");
    } else if (getResetEmail() == 0){
        throw new emailException("Email bestaat niet!");
    }
}


/* checks if two passwords matches. */
function matchPassword(){
    if ($_POST["password"] != $_POST["confirmpassword"]) {
        throw new confirmPasswordException("Wachtwoorden matchen niet!");
    }
}

/* checks if two fbPasswords matches. */
function matchfbPassword(){
    if ($_POST["fbPassword"] != $_POST["fbConfirmpassword"]) {
        throw new fbConfirmPasswordException("Wachtwoorden matchen niet!");
    }
}

/* Checks if captcha is correctly filled in */
function checkCaptcha($captcha){
    if(!$captcha){
        throw  new captchaException("Captcha moet ingevuld worde!");
    } else {
        $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lc72xIUAAAAAPizuF3nUbklCPljVCVzgYespz8o&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']));
        if($response->success==false) {
            throw  new captchaException("Je bent een spammer!");
        }
    }
}

/* Get ip adres */
function getIp(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $GLOBALS["ip"] = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $GLOBALS["ip"] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $GLOBALS["ip"] = $_SERVER['REMOTE_ADDR'];
    }
}

/* Checks if everything is filled in correctly */
function registerCheck($status){
    if ($status == false){
        throw  new registerException("Bepaalde velden zijn verkeerd of niet ingevuld");
    } else {
        registerAccount();
        header("location: login.php");
    }
}

/* Checks if everything is filled in correctly */
function fbRegisterCheck($status){
    if ($status == false){
        throw  new registerException("Bepaalde velden zijn verkeerd of niet ingevuld");
    } else {
        fbRegisterAccount();
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

class lettersAndSpacesException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}


class bdayException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class usernameException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class passwordException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class confirmPasswordException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class fbConfirmPasswordException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class emailException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class confirmEmailException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class captchaException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class registerException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
?>
