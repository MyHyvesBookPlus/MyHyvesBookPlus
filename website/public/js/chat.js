var previousDate = new Date("1970-01-01 00:00:00");
var previousTime = "00:00";
var gettingMessages = false;
var previousType = "robot";

$(document).ready(function() {
    setInterval(loadMessages, 1000);
    sayEmpty();
    $(".chat-field").hide();
});

// This function loads the new messages and runs the addMessages function to show them.
function loadMessages() {
    // If the function is not running elsewhere, run it here.
    if (!gettingMessages) {
        gettingMessages = true;
        // Get the messages.
        $.post(
            "API/loadMessages.php",
            $("#lastIDForm").serialize()
        ).done(function (data) {
            // Post the messages in the chat.
            if (data && data != "[]") {
                messages = JSON.parse(data);
                addMessages(messages);
                $("#lastID").val(messages[messages.length - 1].messageID);
            }

            loadUnreadMessages();

            gettingMessages = false;
        });
    } else {
        setTimeout(loadMessages, 500);
    }
}

// Send a message to a friend of the user.
function sendMessage() {
    $.post(
        "API/sendMessage.php",
        $("#sendMessageForm").serialize()
    ).done(function(response) {
        if (response == "frozen") {
            alert("Je account is bevroren, dus je kan niet chat berichten versturen. Contacteer een admin als je denkt dat dit onjuist is.");
        } else if (response == "logged out") {
            window.location.href = "login.php?url=" + window.location.pathname;
        }
        // Load messages if the message has been send, so it shows in the chat.
        loadMessages();
    });

    $("#newContent").val("");
}

// Add messages to the chat.
function addMessages(messages) {
    var messagesText = "";

    // Loop over all the messages.
    for(var i in messages) {
        // Initialize message variables.
        var thisDate = new Date(messages[i].creationdate.replace(/ /,"T"));
        var thisTime = thisDate.getHours() + ":" + ('0' + thisDate.getMinutes()).slice(-2);
        var type;
        thisDate.setHours(0,0,0,0);

        // See where the message has been send from, so it shows on the right side.
        if (messages[i].destination == $(".destinationID").val()) {
            type = "chat-message-self";
        } else {
            type = "chat-message-other";
        }

        // If it is the first message, open the message box and maybe add a year.
        if (i == 0) {
            if (thisDate.getTime() > previousDate.getTime()) {
                messagesText += '\
                    <div class="day-message"> \
                        <div class="day-message-content">\
                        ' + days[thisDate.getDay()] + " " + thisDate.getDate() + " " + months[thisDate.getMonth()] + " " + thisDate.getFullYear() + '\
                        </div> \
                    </div>';
            }
            previousDate = thisDate;
            previousTime = thisTime;
            previousType = type;
            messagesText += '<div class="chat-message"><div class="' + type + '">';
        // If it is not the first message, and has a different date/time/type then the previous message,
        } else if (type != previousType || thisTime != previousTime || thisDate.getTime() > previousDate.getTime()) {
            // Close the previous message.
            messagesText += '<div class="chat-time">\
                    ' + thisTime + '\
                    </div></div></div>';

            previousTime = thisTime;
            previousType = type;
            // If the date is different, add a new date.
            if (thisDate > previousDate) {
                previousDate = thisDate;
                messagesText += '\
                    <div class="day-message"> \
                        <div class="day-message-content">\
                        ' + days[thisDate.getDay()] + " " + thisDate.getDate() + " " + months[thisDate.getMonth()] + " " + thisDate.getFullYear() + '\
                        </div> \
                    </div>';
            }

            // Open the new message.
            messagesText += '<div class="chat-message"><div class="' + type + '">';
        }

        // Add the content of the message in the new box.
        messagesText += fancyText(messages[i].content) + "<br />";
    }

    // Close the last message
    messagesText += '<div class="chat-time">\
                    ' + thisTime + '\
                    </div></div></div>';

    // Add all the new created messaged to the chat.
    $("#chat-history").append(messagesText);

    // Scroll down, so the user can see the new messages.
    $("#chat-history").scrollTop($("#chat-history")[0].scrollHeight - $('#chat-history')[0].clientHeight);
}

// Switch to a different user.
function switchUser(userID) {
    previousDate = new Date("1970-01-01 00:00:00");
    $(".chat-field").show();
    $(".destinationID").val(userID);
    $("#chat-history").html("");
    $("#lastID").val("");
    $("#chat-recent-panel .friend-item").removeClass("active-friend-chat");
    $("#friend-item-" + userID).addClass("active-friend-chat");
}

// Insert a message in the chat, this is used when it is empty.
function sayEmpty() {
    $("#chat-history").html("Probeer ook eens foto's en video's te sturen");
}