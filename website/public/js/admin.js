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
        console.log($('#batchinput').prop('value'));
    });

    $('#admin-groupbatchform > button').click(function () {
        $('#groupbatchinput').prop('value', $(this).prop('value'));
        console.log($('#batchinput').prop('value'));
    });
});

function checkAll() {
    $('.checkbox-list').each(function () {
        $(this).prop('checked', $('#checkall').prop('checked'));
    });
}

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

function searchFromOne() {
    $('#currentpage').prop('value', 1);
    adminSearch();
}

function adminSearch() {
    console.log($("#admin-searchform").serialize());
    $.post(
        "API/adminSearchUsers.php",
        $("#admin-searchform").serialize()
    ).done(function (data) {
        $("#usertable").html(data);
        updatePageN();
    })
}

function adminUpdate(form) {
    $.post(
        "API/adminChangeUser.php",
        $(form).serialize()
    ).done(function () {
        adminSearch();
    })
}

function updatePageN() {
    $.post(
        "API/adminPageNumber.php",
        $("#admin-searchform").serialize()
    ).done(function (data) {
        $("#admin-pageinfo").html(data);
    })
}

function toggleBancomment(button) {
    $(button).siblings("div").toggle();
    $(button).toggle();
}

function editComment(form) {
    $.post(
        "API/adminChangeUser.php",
        $(form).serialize()
    ).done(function (data) {
        adminSearch();
    });
}