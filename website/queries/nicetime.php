<?php

/**
 * Return a relative dutch and readable text when given a datetime.
 * @param $date
 * @return string
 */
function nicetime($date) {
    if(empty($date)) {
        return "No date provided";
    }

    // Create dutch arrays so it has dutch words.
    $single_periods = array("seconde", "minuut", "uur", "dag", "week", "maand", "jaar", "decennium");
    $multiple_periods = array("seconden", "minuten", "uur", "dagen", "weken", "maanden", "jaar", "decennia");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10", "0");

    $now = time();
    $unix_date = strtotime($date);

    if(empty($unix_date)) {
        return "Bad date";
    }

    // Check if it is in the future or not.
    if($now >= $unix_date) {
        $difference = $now - $unix_date;
        $tense = "geleden";
    } else {
        $difference = $unix_date - $now;
        $tense = "vanaf nu";
    }

    // Get the nice time.
    for($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i++) {
        $difference /= $lengths[$i];
    }

    $difference = round($difference);

    if($difference != 1) {
        $period = $multiple_periods[$i];
    } else {
        $period = $single_periods[$i];
    }

    return "$difference $period $tense";
}