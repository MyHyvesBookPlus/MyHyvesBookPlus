$(document).ready(function() {

    // Toggle menu
    $("#own-profile-picture").click(function() {
        if ($("#notification-center").css('right') == "-256px") {
            // Make the menu visible and move the content to the left.
            $("#chat-history").width("calc(100% - 587px)");
            $(".modal").width("calc(100% - 512px)");
            $(".content").css("margin-right", "256px");
            $("#notification-center").css("right", "0px");
        } else {
            // Make the menu invisible and move the content to the right.
            $("#chat-history").width("calc(100% - 331px)");
            $(".modal").width("calc(100% - 256px)");
            $(".content").css("margin-right", "0px");
            $("#notification-center").css("right", "-256px");
        }
    });
});
