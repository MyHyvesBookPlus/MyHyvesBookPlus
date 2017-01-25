function loadPost(postID) {
    $.get(
        "API/loadPost.php",
        $(postID).serialize()
    ).done(function (data) {
        $('#modal-response').innerHTML= JSON.parse(data);
    });
}