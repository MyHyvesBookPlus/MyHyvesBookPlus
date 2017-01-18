$(document).ready(function() {
    loadMessages();
});

function loadMessages() {
    $.post(
        "loadMessages.php",
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
        "sendMessage.php",
        $("#sendMessageForm").serialize()
    ).done(function( data ) {
        console.log(data);
    });

    $("#newContent").val("");
}

function addMessages(messages) {
    for(i in messages) {
        if (messages[i].origin == 2) {
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
    $(".destinationID").val(userID);
    $("#chat-history").html("");
    $("#lastID").val("");
}