<tr>
    <th><input class="table-checkbox" type="checkbox" id="checkall" name="checkall" onchange="checkAll(this)"></th>
    <th class="table-username">Gebruikersnaam</th>
    <th class="table-status">Status</th>
    <th class="table-comment">Aantekening</th>
    <th class="table-action">Actie</th>
</tr>

<?php
print_r($_POST);

$q = searchSomeGroupsByStatus($offset, $entries, $search, $groupstatus);

while ($group = $q->fetch(PDO::FETCH_ASSOC)) {
    $groupID = $group['groupID'];
    $name = $group['name'];
    $role = $group['status'];
    $description = $group['description'];
    $function = "checkCheckAll(document.getElementById('checkall'))";

    echo("
        <tr>
            <td><input type='checkbox'
                       name='checkbox-group[]'
                       class='checkbox-list'
                       value='$groupID'
                       form='admin-groupbatchform'
                       onchange='$function'>
            </td>
            <td>$name</td>
            <td>$role</td>
            <td>$description</td>
            <td>
                <form class='admin-groupaction'
                      action='API/adminChangeUser.php'
                      method='post'>
                    <select class='action' name='actions'>
                        <option value='hidden'>Hidden</option>
                        <option value='public'>Public</option>
                        <option value='membersonly'>Members</option>
                    </select>
                    <input type='hidden' name='groupID' value='$groupID'>
                    <input type='submit' value='Confirm'>
                </form>
            </td>
        </tr>
    ");
}