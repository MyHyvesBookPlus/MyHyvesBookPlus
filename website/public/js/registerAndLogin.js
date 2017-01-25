function checkLoggedIn() {
    if (confirm("You are already logged in!\nDo you want to logout?\nPress ok to logout.") == true) {
        window.location.href = "logout.php";
    } else {
        window.location.href = "profile.php";
    }
}

function bannedAlert(){
    alert("Your account is banned");
}

function emailNotConfirmed(){
    alert("Your account has not been verified yet!\nAnother email has been sent to you")
}
