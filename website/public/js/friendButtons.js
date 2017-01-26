function placeFriendButtons() {
    $.post("API/getFriendshipStatus.php", { usr: userID })
        .done(function(data) {
            friendshipStatus = data;
            $buttonContainer = $("div.friend-button-container");
            $buttonContainer.children().remove();
            $("#start-profile-chat-form").hide();
            if (friendshipStatus == -1) {
                return;
            } else if(friendshipStatus == 0) {
                $buttonContainer.append($("<button class=\"green friend-button\" value=\"request\"><i class=\"fa fa-handshake-o\"></i> Bevriend</button>"));
            } else if(friendshipStatus == 1) {
                $buttonContainer.append($("<button class=\"red friend-button\" value=\"delete\"><i class=\"fa fa-times\"></i> Verwijder</button>"));
                $("#start-profile-chat-form").show();
            } else if(friendshipStatus == 2) {
                $buttonContainer.append($("<button class=\"red friend-button\" value=\"delete\"><i class=\"fa fa-times\"></i> Trek verzoek in</button>"));
            } else if(friendshipStatus == 3) {
                $buttonContainer.append($("<button class=\"red friend-button\" value=\"delete\"><i class=\"fa fa-times\"></i> Weiger</button>"));
                $buttonContainer.append($("<button class=\"green friend-button\" value=\"accept\"><i class=\"fa fa-check\"></i> Accepteer</button>"));
            }

            $buttonContainer.children().click(function() {
                editFriendship(userID, this.value);
            });
        });
}