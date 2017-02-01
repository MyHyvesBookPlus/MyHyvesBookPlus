function placeGroupButtons() {
    $.post("API/getGrouprole.php", { grp: groupID })
        .done(function(data) {
            var $buttonContainer = $("div.group-button-container");

            if(data == 'none') {
                $buttonContainer.append(
                    "<button class='green group-button' value='request'>" +
                    "<i class='fa fa-plus'></i> Voeg toe" +
                    "</button>");
            } else if(data == 'request') {
                $buttonContainer.append(
                    "<button class='red group-button' value='none'>" +
                    "<i class='fa fa-times'></i> Trek verzoek in" +
                    "</button>");
            } else {
                $buttonContainer.append(
                    "<button class='red group-button' value='none'>" +
                    "<i class='fa fa-times'></i> Verlaat groep" +
                    "</button>");
            }

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