$(document).ready(function() {
    $(".extra-menu-items").hide();

    // Show more friends
    $("#more-friends-click").click(function() {
        // Show only friends
        $("#groups-menu-section").slideUp();
        $("#friends-menu-section a").show();

        // Change buttons
        $("#more-friends-click").hide();
        $("#menu-back").show();
    });

    // Show more groups
    $("#more-groups-click").click(function() {
        // Show only groups
        $("#friends-menu-section").slideUp();
        $("#groups-menu-section a").show();

        // Change buttons
        $("#more-groups-click").hide();
        $("#menu-back").show();
    });

    // Go back
    $("#menu-back").click(function() {
        // Show overview of friends and groups
        $("#friends-menu-section").slideDown();
        $("#groups-menu-section").slideDown();
        $(".extra-menu-items").hide();

        // Change buttons
        $("#menu-back").hide();
        $("#more-groups-click").show();
        $("#more-friends-click").show();
    });
});
