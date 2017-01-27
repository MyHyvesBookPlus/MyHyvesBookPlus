<tr>
    <th><input class="table-checkbox" type="checkbox" id="checkall" name="checkall" onchange="checkAll(this)"></th>
    <th class="table-username">Gebruikersnaam</th>
    <th class="table-status">Status</th>
    <th class="table-comment">Aantekening</th>
    <th class="table-action">Actie</th>
</tr>

<!-- Table construction via php PDO. -->
<?php
$q = searchSomeUsersByStatus($offset, $entries, $search, $status);
while($user = $q->fetch(PDO::FETCH_ASSOC)) {
    $userID = $user['userID'];
    $username = $user['username'];
    $role = $user['role'];
    $bancomment = $user['bancomment'];
    $function = "checkCheckAll(document.getElementById('checkall'))";

    echo("
        <tr>
            <td>
                <input type='checkbox'
                       name='checkbox-user[]'
                       class='checkbox-list'
                       value='$userID'
                       form='admin-batchform'
                       onchange='$function'>
            </td>
            <td>$username</td>
            <td>$role</td>
            <td>$bancomment</td>
            <td>
                <form class='admin-useraction'
                      action='API/adminChangeUser.php'
                      method='post'>
                    <select class='action' name='actions'>
                        <option value='frozen'>Bevries</option>
                        <option value='banned'>Ban</option>
                        <option value='user'>Activeer</option>
                    </select>
                    <input type='hidden' name='userID' value='$userID'>
                    <input type='submit' value='Confirm'>
                </form>
            </td>
        </tr>
    ");
}
