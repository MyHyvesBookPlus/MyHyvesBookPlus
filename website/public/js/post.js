function postComment(buttonValue) {
    formData = $("#newcommentform").serializeArray();
    formData.push({name: "button", value: buttonValue});
    $.post(
        "API/postComment.php",
        formData
    ).done(function(data) {
        console.log(data);
    });

    $("#newcomment").val("");

    //reload post
    $.get(
        "API/loadPost.php",
        $("#newcommentform").serialize()
    ).done(function (data) {
        $('#modal-response').html(data);
    });
}