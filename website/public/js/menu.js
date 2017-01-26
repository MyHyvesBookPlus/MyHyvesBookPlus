
$(document).ready(function() {
    // Show more friends/users

    // Show more friends
    // $("#more-friends-click").click(function() {
    //     // Show only friends
    //     $("#groups-menu-section").slideUp();
    //     $("#friends-menu-section li").show();
    //
    //     // Change buttons
    //     $("#more-friends-click").hide();
    //     $("#menu-back").show();
    // });
    //
    // // Show more groups
    // $("#more-groups-click").click(function() {
    //     // Show only groups
    //     $("#friends-menu-section").slideUp();
    //     $("#groups-menu-section li").show();
    //
    //     // Change buttons
    //     $("#more-groups-click").hide();
    //     $("#menu-back").show();
    // });

    // // Go back
    // $("#menu-back").click(function() {
    //     // Show overview of friends and groups
    //     $("#friends-menu-section").slideDown();
    //     $("#groups-menu-section").slideDown();
    //     $(".extra-menu-items").hide();
    //
    //     // Change buttons
    //     $("#menu-back").hide();
    //     $("#more-groups-click").show();
    //     $("#more-friends-click").show();
    // });

    loadMenuFriends(5);
    loadNotificationFriends();
    loadUnreadMessages();
    loadMenuGroups();
});


function loadMenuFriends(limit) {
    $.post(
        "API/loadFriends.php",
        {
            limit: 5
        }
    ).done(function(data) {
        if (showFriends(data, "#menu-friends-list", 5, "profile.php", "GET", limit)) {
            $("#friends-menu-section").show();
        } else {
            $("#friends-menu-section").hide();
        }
    });

    setTimeout(loadMenuFriends, 3000, limit);
}

function loadMenuGroups() {
    $.post(
        "API/loadGroups.php",
        {
            limit: 5
        }
    ).done(function(data) {
        if (showGroups(data, "#menu-groups-list")) {
            $("#groups-menu-section").show();
        } else {
            $("#groups-menu-section").hide();
        }
    });

    setTimeout(loadMenuGroups, 3000);
}

function loadNotificationFriends() {
    $.post(
        "API/loadFriendRequest.php"
    ).done(function(data) {
        if (showFriendsPlus(data, "#friend-requests-list", 5, "profile.php", "GET")) {
            $("#friend-request-section").show();
        } else {
            $("#friend-request-section").hide();
        }
    });

    setTimeout(loadNotificationFriends, 3000);
}

function loadUnreadMessages() {
    $.post(
        "API/loadChatNotifications.php"
    ).done(function(data) {
        if (showFriendsPlus(data, "#unread-chat-list", 5, "chat.php", "GET")) {
            console.log(data);
            $("#unread-messages-section").show();
        } else {
            $("#unread-messages-section").hide();
        }
    });

    setTimeout(loadUnreadMessages, 3000);
}