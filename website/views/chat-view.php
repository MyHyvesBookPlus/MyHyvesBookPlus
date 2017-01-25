<div class="content">
    <div class="chat">
        <nav class="nav-list platform" id="chat-recent-panel">
            <h5>Chats</h5>
            <ul>
                <?php
                include_once("../queries/friendship.php");

                // Get all the friends of a user.
                $friends = selectAllFriends($_SESSION["userID"]);
                $i = 0;

                // Print all the users.
                while($friend = $friends->fetch(PDO::FETCH_ASSOC)) {
                    $i ++;

                    // Set default values of a friend.
                    $username = $friend["username"];
                    $name = $friend["name"];
                    $userID = $friend["userID"];
                    $pf = "img/avatar-standard.png";

                    // Change values if needed.
                    if (!empty($friend["profilepicture"]))
                        $pf = $friend["profilepicture"];

                    // Echo the friend.
                    echo "
                        <li class='friend-item' id='friend-item-$userID' onclick='switchUser(\"$userID\")'>
                            <div class='friend'>
                                <img alt='PF' class='profile-picture' src='$pf'/>
                                <div class='friend-name'>
                                    $name<br/>
                                    <span style='color: #666'>$username</span>
                                </div>
                            </div>
                        </li>
                    ";
                }
                if (isset($_GET["chatID"]) && $_GET["chatID"] != "") {
                    $chatID = $_GET["chatID"];
                    echo "<script>$(document).ready(function(){switchUser('$chatID')});</script>";
                }
                ?>
            </ul>
        </nav>
        <div id="chat-history" class="chat-history platform">
        </div>
        <div>
            <form id="lastIDForm">
                <input type="hidden"
                       id="lastID"
                       name="lastID"
                       value=""
                />
                <input type="hidden"
                       name="destination"
                       class="destinationID"
                       value=""
                />
            </form>
            <div class="chat-field">
                <form id="sendMessageForm" action="javascript:sendMessage();">
                    <input type="hidden"
                           name="destination"
                           class="destinationID"
                           value=""
                    />
                    <input type="submit"
                           value="Verstuur"
                    />
                    <span>
                        <input type="text"
                               name="content"
                               id="newContent"
                               placeholder="Schrijf een bericht..."
                               autofocus
                               required
                        />
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>