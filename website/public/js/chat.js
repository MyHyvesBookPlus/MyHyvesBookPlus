$(document).ready(function() {
    loadMessages();
    sayEmpty();
    $(".chat-field").hide();
});

function loadMessages() {
    $.post(
        "API/loadMessages.php",
        $("#lastIDForm").serialize()
    ).done(function(data) {
        if (data && data != "[]") {
            console.log(data);
            messages = JSON.parse(data);
            addMessages(messages);
            $("#lastID").val(messages[messages.length - 1].messageID);
            $("#chat-history").scrollTop($("#chat-history")[0].scrollHeight);
        }
    });

    setTimeout(loadMessages, 1000);
}


function sendMessage() {
    console.log($("#sendMessageForm").serialize());
    $.post(
        "API/sendMessage.php",
        $("#sendMessageForm").serialize()
    ).done(function( data ) {
        console.log(data);
    });

    $("#newContent").val("");
}

function addMessages(messages) {
    for(i in messages) {
        if (messages[i].destination == $(".destinationID").val()) {
            type = "chat-message-self";
        } else {
            type = "chat-message-other";
        }

        $("#chat-history").append('\
            <div class="chat-message"> \
                <div class="' + type + '">\
                ' + messages[i].content + '\
                </div> \
            </div>\
        ');
    }
}

function switchUser(userID) {
    $(".chat-field").show();
    $(".destinationID").val(userID);
    $("#chat-history").html("");
    $("#lastID").val("");
    $(".chat-left .friend-item").removeClass("active-friend-chat");
    $(".chat-left #friend-item-" + userID).addClass("active-friend-chat");
}

function sayEmpty() {
    $("#chat-history").html("Begin nu met chatten!");
}