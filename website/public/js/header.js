$(document).ready(function() {
    $("#own-profile-picture").click(function() {
        if($("#notification-center").css('right') == "-256px") {
            $(".content").animate({
                marginRight: "256px"
            }, 500);
            $(".chat-right").animate({
                width: "100%"
            }, 500);
            $("#notification-center").animate({
                right: "0px"
            }, 500);
        } else {
            $(".chat-right").animate({
                width: "100%"
            }, 500);
            $(".content").animate({
                marginRight: "0px"
            }, 500);
            $("#notification-center").animate({
                right: "-256px"
            }, 500);
        }
    });
});
