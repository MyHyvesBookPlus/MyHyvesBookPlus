$(document).ready(function() {
    // Hide notification center.
    $("#profile-menu-popup").hide();

    // $("#own-profile-picture").click(function() {
    //     $("#profile-menu-popup").toggle();
    //     $("#profile-hello-popup").toggle();
    // });

    $("#own-profile-picture").click(function() {
        if($("#notification-center").css('right') == "-256px") {
            $(".content").animate({
                marginRight: "256px"
            }, 500);
            $(".chat-right").animate({
                width: "calc(100% - 512px - 40px)"
            }, 500);
            $("#notification-center").animate({
                right: "0px"
            }, 500);
        } else {
            $(".chat-right").animate({
                width: "calc(100% - 256px - 40px)"
            }, 500);
            $(".content").animate({
                marginRight: "0px"
            }, 500);
            $("#notification-center").animate({
                right: "-256px"
            }, 500);
        }
    });

    $("#own-profile-picture").click();
});
