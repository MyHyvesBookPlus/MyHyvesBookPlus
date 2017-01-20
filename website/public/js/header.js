$(document).ready(function() {
    // Hide notification center.
    $("#profile-menu-popup").hide();

    // $("#own-profile-picture").click(function() {
    //     $("#profile-menu-popup").toggle();
    //     $("#profile-hello-popup").toggle();
    // });

    $("#own-profile-picture").click(function() {
        if($("#notification-center").css('right') == "-256px") {
            // $(".content").animate({
            //     marginRight: "256px"
            // }, 500);
            $("#notification-center").animate({
                right: "0px"
            }, 500);
        } else {
            // $(".content").animate({
            //     marginRight: "0px"
            // }, 500);
            $("#notification-center").animate({
                right: "-256px"
            }, 500);
        }
    });
});
