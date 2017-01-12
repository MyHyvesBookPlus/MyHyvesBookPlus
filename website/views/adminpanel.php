<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="astyle.css">
        <title>Admin Panel</title>
    </head>
    <body>
        <div class="content">
            <div class="admin-panel">
                <form action="index.html" method="post">
                <div class="admin-options">
                    <form action="index.html" method="post">
                        <div class="admin-searchbar">
                            <h2>Search</h2>
                            <input type="text" name="search" class="admin-searchinput"> <br>
                            <input type="submit" value="Search">
                        </div>
                        <div class="admin-filter">
                            <h2>Show users:</h2>
                            <input type="checkbox" name="status" value="Active"> Active <br>
                            <input type="checkbox" name="status" value="Muted"> Muted <br>
                            <input type="checkbox" name="status" value="Banned"> Banned
                        </div>
                    </form>
                        <div class="admin-actions">
                            <h2>Actions: </h2>
                            <input type="radio" name="actions" value="mute"> Mute <br>
                            <input type="radio" name="actions" value="ban"> Ban <br>
                            <input type="radio" name="actions" value="unban"> Unban <br> <br>
                            <input type="submit" value="Confirm">
                        </div>
                </div>
                    <div class="admin-users">
                        <h2>Users:</h2>
                        <table class="usertable">
                            <tr style="text-align: left;">
                                <th><input type="checkbox" name="checkall"></th>
                                <th>User</th>
                                <th>Ban reason</th>
                                <th style="width: 200px;">Action</th>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="check1"></td>
                                <td>John Smith</td>
                                <td>unregulated time travel</td>
                                <td>
                                    <form class="admin-useraction" action="index.html" method="post">
                                        <select class="action" name="actions">
                                            <option value="mute">Mute</option>
                                            <option value="ban">Ban</option>
                                            <option value="unban">Unban</option>
                                        </select>
                                        <input type="submit" value="Confirm">
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="check1"></td>
                                <td>poey jokeaim</td>
                                <td>l33t h4xx</td>
                                <td>
                                    <form class="admin-useraction" action="index.html" method="post">
                                        <select class="action" name="actions">
                                            <option value="mute">Mute</option>
                                            <option value="ban">Ban</option>
                                            <option value="unban">Unban</option>
                                        </select>
                                        <input type="submit" value="Confirm">
                                    </form>
                                </td>
                            </tr>

                        </table>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
