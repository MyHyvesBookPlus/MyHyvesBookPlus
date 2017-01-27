var days = ["zondag", "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag"];
var months = ["januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december"]

function fancyText(text) {

    // Add images and gifs.
    var regex = /(https:\/\/.[^ ]*\.(?:png|jpg|jpeg|gif))/ig;
    text = text.replace(regex, function(img) {
        return "<img src='" + img + "' />";
    });

    // Add links.
    // regex = /(https:\/\/.[^ ]*\.(?:net|com|nl))/ig;
    // text = text.replace(regex, function(link) {
    //     return "<a href='" + link + "'>LINK</a>";
    // });

    return text;
}

function getCookie(key) {
    cookies = document.cookie.split("; ");
    for (var i in cookies) {
        cookie = cookies[i].split("=");
        if (cookie[0] == key) {
            return cookie[1];
        }
    }
    return false;
}

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