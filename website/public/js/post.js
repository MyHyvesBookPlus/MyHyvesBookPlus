function postComment() {
    $.post(
        "API/postComment.php",
        $("#newcommentform").serialize()
    );

    $("#newcomment").val("");

    //reload post
    $.get(
        "API/loadPost.php",
        $("#newcommentform").serialize()
    ).done(function (data) {
        $('#modal-response').html(data);
    });
}


