function placeFriendButtons() {
    $.post("API/getFriendshipStatus.php", { usr: userID })
        .done(function(data) {
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
                    case "1":
                        value1 = "delete";
                        class1 = "red";
                        text1 = "Verwijder";
                        icon1 = "fa-times";
                        value2 = userID;
                        class2 = "green";
                        text2 = "Chat";
                        icon2 = "fa-comment-o";
                        break;
                    case "2":
                        value1 = "delete";
                        class1 = "red";
                        text1 = "Trek verzoek in";
                        icon1 = "fa-cross";
                        break;
                    case "3":
                        value1 = "delete";
                        class1 = "red";
                        text1 = "Weiger";
                        icon1 = "fa-times";
                        value2 = "accept";
                        class2 = "green";
                        text2 = "Accepteer";
                        icon2 = "fa-check";
                        break;
                    default:
                        console.log(friendshipStatus);
                        break;
                }

                $buttonContainer.append(
                    "<button class='"+ class1 +" friend-button' value='"+ value1 +"'>" +
                        "<i class='fa "+ icon1 +"'></i> " + text1 +
                    "</button>");
                $buttonContainer.append(
                    "<button class='"+ class2 +" friend-button' value='"+ value2 +"'>" +
                        "<i class='fa "+ icon2 +"'></i> " + text2 +
                    "</button>");


            $buttonContainer.children().click(function() {
                if (isNaN(this.value))
                    editFriendship(userID, this.value);
                else if (this.value != "")
                    window.location.href = "chat.php?username=" + this.value;
            });
        });
}