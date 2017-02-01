<?php
function nicetime($date) {
    if(empty($date)) {
        return "No date provided";
    }

    $single_periods = array("seconde", "minuut", "uur", "dag", "week", "maand", "jaar", "decennium");
    $multiple_periods = array("seconden", "minuten", "uur", "dagen", "weken", "maanden", "jaar", "decennia");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10", "0");

    $now = time();
    $unix_date = strtotime($date);

    if(empty($unix_date)) {
        return "Bad date";
    }

    if($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = "geleden";
    } else {
        $difference = $unix_date - $now;
        $tense = "vanaf nu";
    }

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