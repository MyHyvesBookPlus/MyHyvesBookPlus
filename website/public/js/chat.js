var previousDate = new Date("1970-01-01 00:00:00");
var previousTime = "00:00";
var gettingMessages = false;
var previousType = "robot";

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
    ).done(function(data) {
        if (data == "0") {
            alert("Je account is bevroren, dus je kan niet chat berichten versturen. Contacteer een admin als je denk dat dit onjuist is.");
        }
    });

    $("#newContent").val("");
    loadMessages();
}

function addMessages(messages) {
    var messagesText = "";
    for(var i in messages) {
        // Initialize message variables
        var thisDate = new Date(messages[i].creationdate);
        var thisTime = thisDate.getHours() + ":" + thisDate.getMinutes();
        var type;
        thisDate.setHours(0,0,0,0);

        if (messages[i].destination == $(".destinationID").val()) {
            type = "chat-message-self";
        } else {
            type = "chat-message-other";
        }
        if (i == 0) {
            if (thisDate > previousDate) {
                previousDate = thisDate;
                messagesText += '\
                    <div class="day-message"> \
                        <div class="day-message-content">\
                        ' + days[thisDate.getDay()] + " " + thisDate.getDate() + " " + months[thisDate.getMonth()] + " " + thisDate.getFullYear() + '\
                        </div> \
                    </div>';
            }
            messagesText += '<div class="chat-message"><div class="' + type + '">';
        } else if (type != previousType || thisTime != previousTime || thisDate > previousDate) {
            messagesText += '<div class="chat-time">\
                    ' + thisTime + '\
                    </div></div></div>';

            previousTime = thisTime;
            previousType = type;
            if (thisDate > previousDate) {
                previousDate = thisDate;
                messagesText += '\
                    <div class="day-message"> \
                        <div class="day-message-content">\
                        ' + days[thisDate.getDay()] + " " + thisDate.getDate() + " " + months[thisDate.getMonth()] + " " + thisDate.getFullYear() + '\
                        </div> \
                    </div>';
            }

            messagesText += '<div class="chat-message"><div class="' + type + '">';
        }
        messagesText += fancyText(messages[i].content) + "<br />";
    }

    // Close the last message
    messagesText += '<div class="chat-time">\
                    ' + thisTime + '\
                    </div></div></div>';

    $("#chat-history").append(messagesText);

    $("#chat-history").scrollTop($("#chat-history")[0].scrollHeight - $('#chat-history')[0].clientHeight);
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
    $("#chat-history").html("Probeer ook eens foto's en video's te sturen");
}