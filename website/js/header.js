$(document).ready(function() {
    $("#profile-menu-popup").hide();
    $("#own-profile-picture").click(function() {
        $("#profile-menu-popup").toggle();
        $("#profile-hello-popup").toggle();
    });
});
