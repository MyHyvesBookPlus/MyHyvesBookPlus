
/**
 * Posts a comment or "Niet slecht." on a post.
 * Button specifies between comment and "Niet slecht.".
 * Alerts or redirects if frozen or not logged in.
 */
function postComment(buttonValue) {
    formData = $("#newcommentform").serializeArray();
    formData.push({name: "button", value: buttonValue});
    $.post(
        "API/postComment.php",
        formData
    ).done(function (response) {
        if (response == "frozen") {
            alert("Je account is bevroren, dus je kan geen comments plaatsen of \"niet slechten\". Contacteer een admin als je denkt dat dit onjuist is.");
        } else if (response == "logged out") {
            window.location.href = "login.php?url=" + window.location.pathname;
        }
    });

    $("#newcomment").val("");

    //reload post
    $.get(
        "API/loadPost.php",
        $("#newcommentform").serialize()
    ).done(function (data) {
        $('#modal-response').html(fancyText(data));
    });
}

/**
 * Deletes a post given by postID, closes modal and reloads posts.
 * @param postID
 */
function deletePost(postID) {
    var formData = [{name: "postID", value: postID}];
    $.post(
        "API/deletePost.php",
        formData
    ).done(function (response) {
        if (response == "frozen") {
            alert("Je account is bevroren, dus je kan geen posts verwijderen. Contacteer een admin als je denkt dat dit onjuist is.");
        } else if (response == "logged out") {
            window.location.href = "login.php?url=" + window.location.pathname;
        }
    });
    closeModal();
    masonry(masonryMode);
}