$(window).on("load", function () {
    changeFilter();
    $(".admin-searchinput").keyup(function(){
        adminSearch();
    });
    // all inputs and labels directly under admin filter and groupfilter
    $("#admin-filter, #admin-groupfilter > input, label").click(function(){
        adminSearch();
    });
    $("#pagetype").change(function(){
        adminSearch();
    });

    adminSearch();
});

function checkAll(allbox) {
    var checkboxes = document.getElementsByClassName('checkbox-list');

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
            checkboxes[i].checked = allbox.checked;
        }
    }
}

function checkCheckAll(allbox) {
    var checkboxes = document.getElementsByClassName('checkbox-list');
    var checked = true;

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
            if (checkboxes[i].checked == false) {
                checked = false;
                break;
            }
        }
    }
    allbox.checked = checked;
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

function adminSearch() {
    $.post(
        "API/adminSearchUsers.php",
        $("#admin-searchform").serialize()
    ).done(function (data) {
        $("#usertable").html(data);
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