function showNotifications(notifications, id) {
    $("#" + id).html("");
    for (i in notifications) {
        $("#" + id).append(" \
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

function loadNotifications() {
    $.post(
        "API/loadFriendRequestNotifications.php"
    ).done(function(data) {
        if (data && data != "[]") {
            showNotifications(JSON.parse(data), "friendrequestslist");
        }
    });
    $.post(
        "API/loadChatNotifications.php"
    ).done(function(data) {
        if (data && data != "[]") {
            showNotifications(JSON.parse(data), "unreadChatlist");
        }
    });

    setTimeout(loadNotifications, 10000);
}
$(document).ready(function() {
    loadNotifications();
});



