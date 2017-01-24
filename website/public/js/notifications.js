function showFriendNotifications(notifications) {
    $("#friendrequestslist").html("");
    for (i in notifications) {
        $("#friendrequestslist").append(" \
            <li class='friend-item $extraItem'> \
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
            </li> \
        ");
    }
}

function showChatNotifications(notifications) {
    $("#unreadChatlist").html("");
    for (i in notifications) {
        $("#unreadChatlist").append(" \
            <li class='friend-item $extraItem'> \
                <form action='chat.php' method='get'> \
                    <button type='submit' \
                            name='username' \
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



