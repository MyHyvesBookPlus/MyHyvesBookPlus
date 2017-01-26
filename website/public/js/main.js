function editFriendship(userID, value) {
    $.post("API/editFriendship.php", { usr: userID, action: value })
    .done(function() {
        placeFriendButtons();
    });
}

function showFriends(friends, list) {
    if(friends && friends != "[]") {
        $(list).load("bits/friend-item.php", {
            "friends": friends
        });

        return true;
    } else {
        return false;
    }
}

function showFriendsPlus(friends, list, limit, action, actionType) {
    if(friends && friends != "[]") {
        $(list).load("bits/friend-item.php", {
            "friends": friends,
            "limit": limit,
            "action": action,
            "actionType": actionType
        });

        return true;
    } else {
        return false;
    }
}

function showGroups(groups, list) {
    if(groups && groups != "[]") {
        $(list).load("bits/group-item.php", {
            "groups": groups
        });

        return true;
    } else {
        return false;
    }
}