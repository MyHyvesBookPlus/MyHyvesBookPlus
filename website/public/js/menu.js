var menuFriendsData;
var menuGroupsData;
var notificationMessagesData;
var notificationRequestsData;
var updatingMenus = 0;

// On document load, load menus and loops loading menus every 10 seconds.
$(document).ready(function() {
    updatingMenus = 4;
    loadMenuFriends(5);
    loadNotificationFriends();
    loadUnreadMessages();
    loadMenuGroups();
    setInterval(updateMenus, 10000);
});


// Update the menu  and notification items.
function updateMenus() {
    if (updatingMenus <= 0) {
        updatingMenus = 4;
        loadMenuFriends(5);
        loadNotificationFriends();
        loadUnreadMessages();
        loadMenuGroups();
    }
}


// Get, every 3 seconds, the friends and insert them in the menu.
function loadMenuFriends(limit) {
    $.post(
        "API/loadFriends.php",
        {
            limit: 5
        }
    ).done(function(data) {
        if (menuFriendsData != data) {
            menuFriendsData = data;
            if (showFriends(data, "#menu-friends-list", 5, "profile.php", "GET", limit)) {
                $("#friends-menu-section").show();
            } else {
                $("#friends-menu-section").hide();
            }
        }
        updatingMenus --;
    });
}

// Get, every 3 seconds, the groups and insert them in the menu.
function loadMenuGroups() {
    $.post(
        "API/loadGroups.php",
        {
            limit: 5
        }
    ).done(function(data) {
        if (menuGroupsData != data) {
            menuGroupsData = data;
            if (showGroups(data, "#menu-groups-list")) {
                $("#groups-menu-section").show();
            } else {
                $("#groups-menu-section").hide();
            }
        }
        updatingMenus --;
    });
}

// Get, every 3 seconds, the friends requests and insert them in the notification center.
function loadNotificationFriends() {
    $.post(
        "API/loadFriendRequest.php"
    ).done(function(data) {
        if (notificationRequestsData != data) {
            notificationRequestsData = data;
            if (showFriendsPlus(data, "#friend-requests-list", 5, "profile.php", "GET")) {
                $("#friend-request-section").show();
            } else {
                $("#friend-request-section").hide();
            }
        }
        updatingMenus --;
    });
}

// Get, every 3 seconds, the unread messages and insert them in the notification center.
function loadUnreadMessages() {
    $.post(
        "API/loadChatNotifications.php"
    ).done(function(data) {
        if (notificationMessagesData != data) {
            notificationMessagesData = data;
            if (showFriendsPlus(data, "#unread-chat-list", 5, "chat.php", "GET")) {
                $("#unread-messages-section").show();
            } else {
                $("#unread-messages-section").hide();
            }
        }
        updatingMenus --;
    });
}