window.onload = function() {
    changeFilter();
};

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
    if (document.getElementById('group').checked) {
        document.getElementById('admin-filter').style.display = 'none';
        document.getElementById('admin-groupfilter').style.display = 'inline-block';

        document.getElementById('admin-batchactions').style.display = 'none';
        document.getElementById('admin-groupbatchactions').style.display = 'inline-block';
    } else {
        document.getElementById('admin-filter').style.display = 'inline-block';
        document.getElementById('admin-groupfilter').style.display = 'none';

        document.getElementById('admin-batchactions').style.display = 'inline-block';
        document.getElementById('admin-groupbatchactions').style.display = 'none';
    }
}
