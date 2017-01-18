// $("#sendMessageForm").submit(function(e) {
function sendMessage() {
    console.log($("#sendMessageForm").serialize());
    $.post(
        "sendMessage.php",
        $("#sendMessageForm").serialize()
    ).done(function( data ) {
        alert( "Data Loaded: " + data );
    });
}

function loadMessages() {

}