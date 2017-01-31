<?php
/**
 * Class AlertMessage
 * abstract class for alertMessages used in
 */
abstract class AlertMessage extends Exception {
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    abstract public function getClass();
}

/**
 * Class HappyAlert
 * class for a happy alert as an exception.
 */
class HappyAlert extends AlertMessage {

    public function __construct($message = "Gelukt!", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getClass() {
        return "settings-message-happy";
    }
}

/**
 * Class AngryAlert
 * class for an angry alert as as exception.
 */
class AngryAlert extends AlertMessage {
    public function __construct($message = "Er is iets fout gegaan.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getClass() {
        return "settings-message-angry";
    }
}