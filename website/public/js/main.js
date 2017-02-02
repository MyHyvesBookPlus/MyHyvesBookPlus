var days = ["zondag", "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag"];
var months = ["januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december"]

function fancyText(text) {
    // Add links, images, gifs and (youtube) video's.
    var regex = /(https?:\/\/.[^ <>"]*)/ig;
    text = text.replace(regex, function(link) {
        // Add images
        if (link.match(/(https?:\/\/.[^ ]*\.(?:png|jpg|jpeg|gif))/ig)) {
            return "<img alt='" + link + "' src='" + link + "' />";
        }
        // Add mp4 video's
        else if (link.match(/(https?:\/\/.[^ ]*\.(?:mp4))/ig)) {
            return "<video width='100%'>" +
                        "<source src='"+ link +"' type='video/mp4'>" +
                        "<b>Je browser ondersteund geen video</b>" +
                "</video><button class='gray' onclick='$(this).prev().get(0).play();'><i class='fa fa-play'></i></button>";
        }
        // Add ogg video's
        else if (link.match(/(https?:\/\/.[^ ]*\.(?:ogg))/ig)) {
            return "<video width='100%'>" +
                "<source src='"+ link +"' type='video/ogg'>" +
                "<b>Je browser ondersteund geen video</b>" +
                "</video><button class='gray' onclick='$(this).prev().get(0).play();'><i class='fa fa-play'></i></button>";
        }
        // Add youtube video's
        else if (link.match(/(https?:\/\/.(www.)?youtube|youtu.be)*watch/ig)) {
            return '<iframe width="100%"' +
                    ' src="https://www.youtube.com/embed/' + link.substr(link.length - 11) +
                    '" frameborder="0" allowfullscreen></iframe>';
        }
        // Add links
        else {
            return "<a href='" + link + "' target='_blank'>" + link + "</a>";
        }
    });

    return text;
}

// This function gets the value of a cookie when given a key.
// If didn´t find any compatible cookie, it returns false.
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

// Edit the friendship status of two users.
function editFriendship(userID, value) {
    $.post("API/editFriendship.php", { usr: userID, action: value })
    .done(function() {
        placeFriendButtons();
        updateMenus();
    });
}

// Show the given friends in the given list.
// The friends are giving in JSON, and the list is giving with a hashtag.
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

// Show the given friends in the given list.
// This function supports more options given as parameters. This adds extra functionality.
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

// Show the given groups in the given list.
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