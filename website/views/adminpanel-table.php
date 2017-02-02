<tr>
    <th><input class="table-checkbox" type="checkbox" id="checkall" name="checkall" onchange="checkAll()"></th>
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

    echo("
        <tr>
            <td>
                <input type='checkbox'
                       name='checkbox-user[]'
                       class='checkbox-list'
                       value='$userID'
                       form='admin-batchform'
                       onchange='checkCheckAll();'>
            </td>
            <td>$username</td>
            <td>$role</td>
            <td>
                <div class='bancomment'>$bancomment</div>
                <div class='bancommentedit'>
                    <form class='bancommentform'
                          id='bancommentform'
                          onsubmit='editComment(this); 
                                    return false;'>
                          <input type='text'
                                 name='bancommenttext'
                                 placeholder='Schrijf een aantekening'
                                 value='$bancomment'>
                          <input type='hidden'
                                 name='bancommentuserID'
                                 value='$userID'>
                          <button type='submit'>Update</button>
                    </form>
                </div>
                <button type='button' onclick='toggleBancomment(this)'>Verander</button>
            </td>
            <td>
                <form class='admin-useraction'
                      onsubmit=\"adminUpdate(this);  return false;\">
                    <select class='action' name='actions'>");
                        if (!($userinfo == 'admin'
                              AND ($user['role'] == 'admin'
                              OR $user['role'] == 'owner'))) {
                            echo "<option value='frozen'>Bevries</option>
                                  <option value='banned'>Ban</option>
                                  <option value='user'>Activeer</option>
                                  <option value='unconfirmed'>Ongevalideerd</option>";

                            if ($userinfo == 'owner') {
                                echo "<option value='admin'>Admin</option>
                                      <option value='owner'>Owner</option>";
                            }
                        }

                    echo ("</select>
                    <input type='hidden' name='userID' value='$userID'>
                    <input type='submit' value='Confirm'>
                </form>
            </td>
        </tr>
    ");
}
