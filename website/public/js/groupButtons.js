function placeGroupButtons() {
    $.post("API/getGrouprole.php", { grp: groupID })
        .done(function(data) {
            var $buttonContainer = $("div.group-button-container");

            if (data == 'none') {
                $buttonContainer.append(
                    "<button class='green group-button group-button-fixed' value='request'>" +
                    "<i class='fa fa-plus'></i> Voeg toe" +
                    "</button>");
            } else if (data == 'request') {
                $buttonContainer.append(
                    "<button class='red group-button group-button-fixed' value='none'>" +
                    "<i class='fa fa-times'></i> Trek verzoek in" +
                    "</button>");
            } else if (data == 'admin') {
                $buttonContainer.append(
                    "<button class='group-button group-button-fancy' value='admin'>" +
                        "<span>Instellingen</span><i class='fa fa-cogs'></i>" +
                        "</button>"
                );
            } else {
                $buttonContainer.append(
                    "<button class='red group-button group-button-fancy' value='none'>" +
                    "<span>Verlaat groep</span><i class='fa fa-sign-out'></i>" +
                    "</button>");
            }

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