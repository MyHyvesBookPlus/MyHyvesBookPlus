function showChatNotifications(notifications) {
    $("#unreadChatlist").html("");
    for (i in notifications) {
        $("#unreadChatlist").append(" \
            <li class='friend-item'> \
                <form action='chat.php' method='get'> \
                    <button type='submit' \
                            name='chatID' \
                            value='"+ notifications[i].userID +"'> \
                        <div class='friend'> \
                            <img alt='PF' class='profile-picture' src='"+ notifications[i].profilepicture +"'/> \
                            <div class='friend-name'> \
                                "+ notifications[i].name +"<br/> \
                                <span style='color: #666'>"+ notifications[i].content +"</span> \
                            </div> \
                        </div> \
                    </button> \
                </form> \
            </li> \
        ");
    }
}

function loadNotifications() {
    $.post(
        "API/loadChatNotifications.php"
    ).done(function(data) {
        if (data && data != "[]") {
            $("#unread-messages-section").show();
            showChatNotifications(JSON.parse(data));
        } else {
            $("#unread-messages-section").hide();
        }
    });

    setTimeout(loadNotifications, 10000);
}
$(document).ready(function() {
    loadNotifications();
});



