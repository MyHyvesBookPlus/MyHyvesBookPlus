// Show the right friendship buttonsto the user.
function placeFriendButtons() {
    $.post("API/getFriendshipStatus.php", { usr: userID })
        .done(function(data) {
            //save the friendship status
            var friendshipStatus = data;
            var $buttonContainer = $("div.friend-button-container");
            $("#start-profile-chat").hide();
                $buttonContainer.html("");
                var value1 = "";
                var class1 = "empty-button";
                var icon1 = "";
                var text1 = "";

                var value2 = "";
                var class2 = "empty-button";
                var icon2 = "";
                var text2 = "";

                switch (friendshipStatus) {
                    case "0":
                        value1 = "request";
                        class1 = "green";
                        text1 = "Bevriend";
                        icon1 = "fa-handshake-o";
                        break;
                        // Users are friends.
                    case "1":
                        value1 = userID;
                        class1 = "green";
                        text1 = "Chat";
                        icon1 = "fa-comment-o";
                        value2 = "delete";
                        class2 = "red";
                        text2 = "Verwijder";
                        icon2 = "fa-times";
                        break;
                        // This user sent request.
                    case "2":
                        value1 = "delete";
                        class1 = "red";
                        text1 = "Trek verzoek in";
                        icon1 = "fa-cross";
                        break;
                        // Other user sent request.
                    case "3":
                        value1 = "accept";
                        class1 = "green";
                        text1 = "Accepteer";
                        icon1 = "fa-check";
                        value2 = "delete";
                        class2 = "red";
                        text2 = "Weiger";
                        icon2 = "fa-times";
                        break;
                }

                // Append buttons to the container.
                $buttonContainer.append(
                    "<button class='"+ class1 +" friend-button' value='"+ value1 +"'>" +
                        "<i class='fa "+ icon1 +"'></i> " + text1 +
                    "</button>");
                $buttonContainer.append(
                    "<button class='"+ class2 +" friend-button' value='"+ value2 +"'>" +
                        "<i class='fa "+ icon2 +"'></i> " + text2 +
                    "</button>");

            // Gets triggered when a friend button is triggered.
            $buttonContainer.children().click(function() {
                if (isNaN(this.value))
                    editFriendship(userID, this.value);
                else if (this.value != "")
                    window.location.href = "chat.php?username=" + this.value;
            });
        });
}