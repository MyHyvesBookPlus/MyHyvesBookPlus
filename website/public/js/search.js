$(window).on('load', function () {
    pageNumber();
});

// Search for the users and put them in the user list.
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

// Search for the groups and put them in the group list.
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

// Get the page numbers and return them in the select.
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