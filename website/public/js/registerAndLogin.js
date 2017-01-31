function checkLoggedIn() {
    if (confirm("U bent al ingelogd!\nWilt u uitloggen?\nKlik ok om uit te loggen.") == true) {
        window.location.href = "logout.php";
    } else {
        window.location.href = "profile.php";
    }
}

function bannedAlert(){
    alert("Uw account is geband!");
}

function frozenAlert(){
    alert("Uw account is bevroren!\n");
}

function emailNotConfirmed(){
    alert("Uw account is nog niet bevestigd!\nEr is een nieuwe email gestuurd om uw account te bevestigen");
}
