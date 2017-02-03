// Checks if user is logged in and offers to logout.
function checkLoggedIn() {
    if (confirm("U bent al ingelogd!\nWilt u uitloggen?\nKlik ok om uit te loggen.") == true) {
        window.location.href = "logout.php";
    } else {
        window.location.href = "profile.php";
    }
}

// Alert for validation mail.
function emailAlert(){
    alert("Bevestigingsemail is gestuurd!\n");
}

// Alert for banned account.
function bannedAlert(){
    alert("Uw account is geband!");
}

// Alert for frozen account.
function frozenAlert(){
    alert("Uw account is bevroren!\n");
}

// Alert for unconfirmed email.
function emailNotConfirmed(){
    alert("Uw account is nog niet bevestigd!\nEr is een nieuwe email gestuurd om uw account te bevestigen");
}
