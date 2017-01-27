function searchUsers(n, m) {
    $.post(
        "API/searchUsers.php",
        {
            n: n,
            m: m,
            search: $("#search-input").val(),
            filter: $("#search-filter").val()
        }
    ).done(function(data) {
        if (!showFriends(data, "#search-users-list", 0, "profile.php", "GET")) {
            $("#search-users-list").text("Niemand gevonden");
        }
    });
}

function searchGroups(n, m) {
    $.post(
        "API/searchGroups.php",
        {
            n: n,
            m: m,
            search: $("#search-input").val(),
            filter: $("#search-filter").val()
        }
    ).done(function(data) {
        if (!showGroups(data, "#search-groups-list")) {
            $("#search-groups-list").text("Geen groepen gevonden");
        }
    });
}