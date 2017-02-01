$(document).ready(function() {
    // Toggle menu
    $("#own-profile-picture, #open-notifications").click(function() {
            if ($("#notification-center").css('display') == "none") {
                // Make the menu visible and move the content to the left.
                $(".modal").width("calc(100% - 512px)");
                $(".content").css("margin-right", "256px");
                $("#notification-center").css("right", "0px");
                $("#notification-center").css("display", "block");
                $("#contact-menu").css("display", "block");

                // Add cookie so the menu stays open on other pages
                if (window.innerWidth > 1080) {
                    $("#chat-history").width("calc(100% - 587px)");
                    document.cookie = "menu=open; path=/";
                } else {
                    document.cookie = "menu=closed; path=/";
                }
            } else {
                $(".modal").width("calc(100% - 256px)");
                $(".content").css("margin-right", "0px");
                $("#notification-center").css("display", "none");

                if (window.innerWidth > 1080) {
                    $("#chat-history").width("calc(100% - 331px)");
                } else {
                    // Make the menu invisible and move the content to the right.
                    $("#contact-menu").css("display", "none");
                }

                // Change menu cookie to close
                document.cookie = "menu=closed; path=/";

            }
    });

    if (getCookie("menu") == "open") {
        $("#own-profile-picture").click();
    }
});
