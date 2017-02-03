$(window).on("load", function () {
    changeFilter();
    searchFromOne();

    $(".admin-searchinput").keyup(function(){
        searchFromOne();
    });
    // all inputs and labels directly under admin filter and groupfilter
    $("#admin-filter, #admin-groupfilter > input, label").change(function(){
        searchFromOne();
    });
    $("#pagetype").change(function(){
        searchFromOne();
    });

    /* Update hidden input to be equal to submit pressed,
        because serialize doesn't take submit values. */
    $('#admin-batchform > button').click(function () {
        $('#batchinput').prop('value', $(this).prop('value'));
    });

    $('#admin-groupbatchform > button').click(function () {
        $('#groupbatchinput').prop('value', $(this).prop('value'));
    });
});

// Toggles all checkboxes based on one.
function checkAll() {
    $('.checkbox-list').each(function () {
        $(this).prop('checked', $('#checkall').prop('checked'));
    });
}

// Simple function that checks if checkall should stay checked.
function checkCheckAll() {
    var checked = true;

    $('.checkbox-list').each(function () {
        if ($(this).prop('checked') == false) {
            checked = false;
            return;
        }
    });

    $('#checkall').prop('checked', checked);
}

// Toggle of filter options.
function changeFilter() {
    if ($('#pagetype').find(":selected").val() == "group") {
        document.getElementById('admin-filter').style.display = 'none';
        document.getElementById('admin-groupfilter').style.display = 'inline-block';

        document.getElementById('admin-batchform').style.display = 'none';
        document.getElementById('admin-groupbatchform').style.display = 'inline-block';
    } else {
        document.getElementById('admin-filter').style.display = 'inline-block';
        document.getElementById('admin-groupfilter').style.display = 'none';

        document.getElementById('admin-batchform').style.display = 'inline-block';
        document.getElementById('admin-groupbatchform').style.display = 'none';
    }
}

// Sets the search page to one, relevant when changing filter or search.
function searchFromOne() {
    $('#currentpage').prop('value', 1);
    adminSearch();
}

// AJAX live search.
function adminSearch() {
    $.post(
        "API/adminSearchUsers.php",
        $("#admin-searchform").serialize()
    ).done(function (data) {
        $("#usertable").html(data);
        updatePageN();
    })
}

// AJAX live update.
function adminUpdate(form) {
    $.post(
        "API/adminChangeUser.php",
        $(form).serialize()
    ).done(function () {
        adminSearch();
    })
}

// AJAX pagenumber functionality.
function updatePageN() {
    $.post(
        "API/adminPageNumber.php",
        $("#admin-searchform").serialize()
    ).done(function (data) {
        $("#admin-pageinfo").html(data);
    })
}

// Intended for the edit button to show a form.
function toggleBancomment(button) {
    $(button).siblings("div").toggle();
    $(button).toggle();
}

// AJAX value editing.
function editComment(form) {
    $.post(
        "API/adminChangeUser.php",
        $(form).serialize()
    ).done(function (data) {
        adminSearch();
    });
}