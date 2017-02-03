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
                        text1 = "Word vrienden";
                        icon1 = "fa-user-plus";
                        break;
                    case "1":
                        value1 = userID;
                        class1 = "green";
                        text1 = "Chat";
                        icon1 = "fa-comment";
                        value2 = "delete";
                        class2 = "red";
                        text2 = "Ontvriend";
                        icon2 = "fa-user-times";
                        break;
                    case "2":
                        value1 = "delete";
                        class1 = "red";
                        text1 = "Trek verzoek in";
                        icon1 = "fa-times";
                        break;
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

                $buttonContainer.append(
                    "<div><button class='"+ class1 +" fancy-button friend-button' value='"+ value1 +"'>" +
                    "<span>"+ text1 +"</span>" +
                    "<i class='fa fa-fw "+ icon1 +"'></i> " +
                    "</button></div>");
                $buttonContainer.append(
                    "<div><button class='"+ class2 +" fancy-button friend-button' value='"+ value2 +"'>" +
                    "<span>"+ text2 +"</span>" +
                    "<i class='fa fa-fw "+ icon2 +"'></i> " +
                    "</button></div>");


            $buttonContainer.find("button").click(function() {
                if (isNaN(this.value))
                    editFriendship(userID, this.value);
                else if (this.value != "")
                    window.location.href = "chat.php?username=" + this.value;
            });
        });
}