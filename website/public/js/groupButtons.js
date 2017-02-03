function placeGroupButtons() {
    $.post("API/getGrouprole.php", { grp: groupID })
        .done(function(data) {
            var $buttonContainer = $("div.group-button-container");

            // Append the right group button to the button container.
            // When user is not a member
            if(data == 'none') {
                $buttonContainer.append(
                    "<button class='green group-button' value='request'>" +
                    "<i class='fa fa-plus'></i> Voeg toe" +
                    "</button>");
                // when user sent a request to become a member.
            } else if(data == 'request') {
                $buttonContainer.append(
                    "<button class='red group-button' value='none'>" +
                    "<i class='fa fa-times'></i> Trek verzoek in" +
                    "</button>");
                // When user is a member of the group.
            } else {
                $buttonContainer.append(
                    "<button class='red group-button' value='none'>" +
                    "<i class='fa fa-times'></i> Verlaat groep" +
                    "</button>");
            }

            // Gets triggered when a group button is clicked.
            $buttonContainer.children().click(function() {
                $.post("API/editMembership.php", { grp: groupID, role: this.value })
                    .done(function() {
                        $buttonContainer.children().remove();
                        placeGroupButtons();
                        updateMenus();
                    }).fail(function() {
                });
            });

    });
}