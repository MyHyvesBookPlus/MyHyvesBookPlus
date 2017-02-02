
function postComment(buttonValue) {
    formData = $("#newcommentform").serializeArray();
    formData.push({name: "button", value: buttonValue});
    $.post(
        "API/postComment.php",
        formData
    ).done(function (response) {
        if (response == "frozen") {
            alert("Je account is bevroren, dus je kan geen comments plaatsen of \"niet slechten\". Contacteer een admin als je denkt dat dit onjuist is.");
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

function deletePost(postID) {
    var formData = [{name: "postID", value: postID}];
    $.post(
        "API/deletePost.php",
        formData
    ).done(function (response) {
        if (response == "frozen") {
            alert("Je account is bevroren, dus je kan geen posts verwijderen. Contacteer een admin als je denkt dat dit onjuist is.");
        }
    });
    closeModal();
    masonry(masonryMode);


}