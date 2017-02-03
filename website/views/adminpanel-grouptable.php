<tr>
    <th><input class="table-checkbox" type="checkbox" id="checkall" name="checkall" onchange="checkAll(this)"></th>
    <th class="table-username">Groepsnaam</th>
    <th class="table-status">Status</th>
    <th class="table-comment">Beschrijving</th>
    <th class="table-action">Zichtbaarheid</th>
</tr>

<?php
print_r($_POST);

$q = searchSomeGroupsByStatus($offset, $entries, $search, $groupstatus);

while ($group = $q->fetch(PDO::FETCH_ASSOC)) {
    $groupID = $group['groupID'];
    $name = $group['name'];
    $role = $group['status'];
    $description = $group['description'];

    echo("
        <tr>
            <td><input type='checkbox'
                       name='checkbox-group[]'
                       class='checkbox-list'
                       value='$groupID'
                       form='admin-groupbatchform'
                       onchange='checkCheckAll();'>
            </td>
            <td>$name</td>
            <td>$role</td>
            <td>$description</td>
            <td>
                <form class='admin-groupaction'
                      onsubmit=\"adminUpdate(this);  return false;\">
                    <select class='action' name='actions'>
                        <option value='hidden'>Verborgen</option>
                        <option value='public'>Publiek</option>
                        <option value='membersonly'>Alleen Leden</option>
                    </select>
                    <input type='hidden' name='groupID' value='$groupID'>
                    <input type='submit' value='Confirm'>
                </form>
            </td>
        </tr>
    ");
}