<div class="content">
    <div class="chat">
        <nav class="nav-list chat-left left platform chat-recent">
            <h5>Chats</h5>
            <ul>
                <?php
                include_once("../queries/friendship.php");

                if (empty($_SESSION["userID"]))
                    $_SESSION["userID"] = 2;

                // Get all the friends of a user.
                $friends = selectAllFriends($db, $_SESSION["userID"]);
                $i = 0;

                // Print all the users.
                while($friend = $friends->fetch(PDO::FETCH_ASSOC)) {
                    $i ++;

                    // Set default values of a friend.
                    $username = $friend["username"];
                    $userID = $friend["userID"];
                    $pf = "img/notbad.jpg";

                    // Change values if needed.
                    if (!empty($friend["profilepicture"]))
                        $pf = $friend["profilepicture"];

                    // Echo the friend.
                    echo "
                        <li class='friend-item' onclick='switchUser(\"$userID\")'>
                            <div class='friend'>
                                <img alt='PF' class='profile-picture' src='$pf'/>
                                $username
                            </div>
                        </li>
                ";
                }
                ?>
            </ul>
            <!--            <a href="#">-->
            <!--                <div class="chat-conversation">-->
            <!--                    <img class="profile-picture" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDnuRSeeyPve7KwDvJJ6OBzj3gyghwLcE2z9kZeYBOyZavh3mw">-->
            <!--                    Rudolf Leslo-->
            <!--                </div>-->
            <!--            </a>-->
        </nav>
        <div class="chat-right right">
            <div id="chat-history" class="chat-history platform">
            </div>
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
                               placeholder="Reageer..."
                               autofocus
                               required
                        />
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>