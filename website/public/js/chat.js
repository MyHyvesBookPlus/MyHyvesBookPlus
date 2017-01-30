var previousDate = new Date("1970-01-01 00:00:00");
var gettingMessages = false;


$(document).ready(function() {
    setInterval(loadMessages, 1000);
    sayEmpty();
    $(".chat-field").hide();
});

function loadMessages() {
    if (!gettingMessages) {
        gettingMessages = true;
        $.post(
            "API/loadMessages.php",
            $("#lastIDForm").serialize()
        ).done(function (data) {
            if (data && data != "[]") {
                messages = JSON.parse(data);
                addMessages(messages);
                $("#lastID").val(messages[messages.length - 1].messageID);
            }
            gettingMessages = false;
        });
    } else {
        setTimeout(loadMessages, 500);
    }
}


function sendMessage() {
    $.post(
        "API/sendMessage.php",
        $("#sendMessageForm").serialize()
    );

    $("#newContent").val("");
    loadMessages();
}

function addMessages(messages) {
    for(var i in messages) {
        thisDate = new Date(messages[i].creationdate);
        thisDate.setHours(0,0,0,0);
        if (messages[i].destination == $(".destinationID").val()) {
            type = "chat-message-self";
        } else {
            type = "chat-message-other";
        }
        if (thisDate > previousDate) {
            previousDate = thisDate;
            $("#chat-history").append('\
                <div class="day-message"> \
                    <div class="day-message-content">\
                    ' + days[thisDate.getDay()] + " " + thisDate.getDate() + " " + months[thisDate.getMonth()] + " " + thisDate.getFullYear() + '\
                    </div> \
                </div>\
            ');
        }
        $("#chat-history").append('\
            <div class="chat-message"> \
                <div class="' + type + '">\
                ' + fancyText(messages[i].content) + '\
                </div> \
            </div>\
        ');
    }

    $("#chat-history").scrollTop($("#chat-history")[0].scrollHeight);
}

function switchUser(userID) {
    previousDate = new Date("1970-01-01 00:00:00");
    $(".chat-field").show();
    $(".destinationID").val(userID);
    $("#chat-history").html("");
    $("#lastID").val("");
    $("#chat-recent-panel .friend-item").removeClass("active-friend-chat");
    $("#friend-item-" + userID).addClass("active-friend-chat");
}

function sayEmpty() {
    $("#chat-history").html("Begin nu met chatten!");
}