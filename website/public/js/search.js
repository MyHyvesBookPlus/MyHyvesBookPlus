$(window).on('load', function () {
    pageNumber();
});

function searchUsers() {
    $.post(
        "API/searchUsers.php",
        $('#search-form').serialize()
    ).done(function(data) {
        if (!showFriends(data, "#search-users-list", 0, "profile.php", "GET")) {
            $("#search-users-list").text("Niemand gevonden");
        }
    });
}

function searchGroups() {
    $.post(
        "API/searchGroups.php",
        $('#search-form').serialize()
    ).done(function(data) {
        if (!showGroups(data, "#search-groups-list")) {
            $("#search-groups-list").text("Geen groepen gevonden");
        }
    });
}

function pageNumber() {
    var input = input2 = $('#search-form').serialize();
    $.post(
        "API/searchPageNumber.php",
        input + "&option=user"
    ).done(function (data) {
        $('#user-pageselect').html(data);
    });
    $.post(
        "API/searchPageNumber.php",
        input2 + "&option=group"
    ).done(function (data) {
        $('#group-pageselect').html(data);
    });
}