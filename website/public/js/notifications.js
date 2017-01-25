function showFriendNotifications(notifications) {
    $("#friendrequestslist").html("");
    for (i in notifications) {
        var outgoing = "";
        if (notifications[i].friend_state == "3") {
            outgoing = "<button\
                            name='accept' \
                            class='accept-notification' \
                            value='"+ notifications[i].userID +"'> \
                        <i class='fa fa-check'></i> \
                        </button>";
        }

        $("#friendrequestslist").append(" \
            <li class='friend-item'> \
                <form action='profile.php' method='get'> \
                    <button type='submit' \
                            name='username' \
                            value='"+ notifications[i].username +"'> \
                        <div class='friend'> \
                            <img alt='PF' class='profile-picture' src='"+ notifications[i].profilepicture +"'/> \
                            "+ notifications[i].username +" \
                        </div> \
                    </button> \
                </form> \
                <div class='notification-options'>\
                    <form action='API/edit_friendship.php' method='post'> \
                        <input type='hidden' name='userID' value='"+ notifications[i].userID +"' /> \
                        "+ outgoing +" \
                        <button type='submit' \
                                name='delete' \
                                class='deny-notification' \
                                value='"+ notifications[i].userID +"'> \
                            <i class='fa fa-times'></i> \
                        </button>\
                    <form>\
                </div> \
            </li> \
        ");
    }
}

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
        "API/loadFriendRequestNotifications.php"
    ).done(function(data) {
        if (data && data != "[]") {
            showFriendNotifications(JSON.parse(data));
        }
    });
    $.post(
        "API/loadChatNotifications.php"
    ).done(function(data) {
        if (data && data != "[]") {
            showChatNotifications(JSON.parse(data));
        }
    });

    setTimeout(loadNotifications, 10000);
}
$(document).ready(function() {
    loadNotifications();
});



