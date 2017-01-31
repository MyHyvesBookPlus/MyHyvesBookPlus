<?php
/**
 * calculates the age of a user
 * @param string $bdayAsString
 * @return int age
 */
function getAge(string $bdayAsString) : int {
    $bday = new DateTime($bdayAsString);
    $today = new DateTime("now");
    $interval = $bday->diff($today);
    return $interval->y;
}