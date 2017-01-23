function showNotifications(notifications, id) {
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

function loadNotifications() {
    $.post(
        "API/loadNotifications.php"
    ).done(function(data) {
        if (data && data != "[]") {
            showNotifications(JSON.parse(data), "friendrequestslist");
        }
    });

    setTimeout(loadNotifications, 10000);
}

loadNotifications();

