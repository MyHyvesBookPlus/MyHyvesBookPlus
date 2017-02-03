function placeGroupButtons() {
    $.post("API/getGrouprole.php", { grp: groupID })
        .done(function(data) {
            var $buttonContainer = $("div.group-button-container");

            // Append the right group button to the button container.
            // When user is not a member
            if(data == 'none') {
                $buttonContainer.append(
                    "<button class='green group-button fancy-button' value='request'>" +
                    "<span>Treed toe</span><i class='fa fa-plus'></i>" +
                    "</button>");

                // when user sent a request to become a member.
            } else if(data == 'request') {
                $buttonContainer.append(
                    "<button class='red group-button fancy-button' value='none'>" +
                    "<span>Trek verzoek in</span><i class='fa fa-times'></i>" +
                    "</button>");
                // When user is a member of the group.
            } else if (data == 'admin') {
                $buttonContainer.append(
                    "<button class='group-button fancy-button' value='admin'>" +
                        "<span>Instellingen</span><i class='fa fa-cogs'></i>" +
                        "</button>"
                );

            } else {
                $buttonContainer.append(
                    "<button class='red group-button fancy-button' value='none'>" +
                    "<span>Verlaat groep</span><i class='fa fa-sign-out'></i>" +
                    "</button>");
            }

            // Gets triggered when a group button is clicked.
            $buttonContainer.children().click(function() {
                if (this.value == 'admin') {
                    window.location.href='groupAdmin.php?groupID=' + groupID;
                } else {
                    $.post("API/editMembership.php", {grp: groupID, role: this.value})
                        .done(function () {
                            $buttonContainer.children().remove();
                            placeGroupButtons();
                            updateMenus();
                        }).fail(function () {
                    });
                }
            });

    });
}