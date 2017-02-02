var menuFriendsData;
var menuGroupsData;
var notificationMessagesData;
var notificationRequestsData;
var updatingMenus = 0;

// On document load, load menus and loops loading menus every 10 seconds.
$(document).ready(function() {
    updateMenus();
    setInterval(updateMenus, 10000);
});


// Update the menu  and notification items.
function updateMenus() {
    if (updatingMenus <= 0) {
        loadMenuFriends(5);
        loadNotificationFriends();
        loadUnreadMessages();
        loadMenuGroups();
    }
}


// Get the friends and insert them in the menu.
function loadMenuFriends(limit) {
    updatingMenus ++;
    $.post(
        "API/loadFriends.php",
        {
            limit: 5
        }
    ).done(function(data) {
        if (data == "" || data == "[]") {
            $("#friends-menu-section").hide();
        } else {
            $("#friends-menu-section").show();
        }
        if (menuFriendsData != data) {
            menuFriendsData = data;
            if (!showFriends(data, "#menu-friends-list", 5, "profile.php", "GET", limit)) {
                $("#friends-menu-section").hide();
            }
        }
    }).fail(function() {
        $("#friends-menu-section").hide();
    }).always(function() {
        updatingMenus --;
    });
}

// Get the groups and insert them in the menu.
function loadMenuGroups() {
    updatingMenus ++;
    $.post(
        "API/loadGroups.php",
        {
            limit: 5
        }
    ).done(function(data) {

        if (data == "" || data == "[]") {
            $("#groups-menu-section").hide();
        } else {
            $("#groups-menu-section").show();
        }
        if (menuGroupsData != data) {
            menuGroupsData = data;
            if (!showGroups(data, "#menu-groups-list")) {
                $("#groups-menu-section").hide();
            }
        }
    }).fail(function() {
        $("#groups-menu-section").hide();
    }).always(function() {
        updatingMenus --;
    });
}

// Get the friends requests and insert them in the notification center.
function loadNotificationFriends() {
    updatingMenus ++;
    $.post(
        "API/loadFriendRequest.php"
    ).done(function(data) {
        if (data == "" || data == "[]") {
            $("#friend-request-section").hide();
        } else {
            $("#friend-request-section").show();
        }
        if (notificationRequestsData != data) {
            notificationRequestsData = data;
            if (!showFriendsPlus(data, "#friend-requests-list", 5, "profile.php", "GET")) {
                $("#friend-request-section").hide();
            }
        }
    }).fail(function() {
        $("#friend-request-section").hide();
    }).always(function() {
        updatingMenus --;
    });
}

// Get the unread messages and insert them in the notification center.
function loadUnreadMessages() {
    updatingMenus ++;
    $.post(
        "API/loadChatNotifications.php"
    ).done(function(data) {
        if (data == "" || data == "[]") {
            $("#unread-messages-section").hide();
        } else {
            $("#unread-messages-section").show();
        }
        if (notificationMessagesData != data) {
            notificationMessagesData = data;
            if (!showFriendsPlus(data, "#unread-chat-list", 5, "chat.php", "GET")) {
                $("#unread-messages-section").hide();
            }
        }
    }).fail(function() {
        $("#unread-messages-section").hide();
    }).always(function() {
        updatingMenus --;
    });
}