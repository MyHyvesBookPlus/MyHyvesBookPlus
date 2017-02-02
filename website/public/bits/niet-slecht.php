<?php
if (isset($_GET["groupname"])) {
    $url = "https://myhyvesbookplus.nl/~lars/group.php?groupname=" . $_GET["groupname"];
} else {
    $url = "https://myhyvesbookplus.nl/";
}
?>
<a href="<?= $url ?>" target='_blank'><img style="width: 100%; height: auto;" src="../external/nietslecht_button.png" alt='\"Niet slecht\" ons op MyHyvesbook+' /></a>
