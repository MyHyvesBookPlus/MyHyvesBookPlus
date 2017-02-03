
// Get the modal
var modal = document.getElementById('myModal');
var registerModal = document.getElementById('registerModal');
var facebookModal = document.getElementById("fbModal");

// Get the button that opens the modal
var registerBtn = document.getElementById("registerBtn");
var btn = document.getElementById("myBtn");
var fbBtn = document.getElementById("fbBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var registerSpan = document.getElementsByClassName("close")[1];
var facebookCLose = document.getElementsByClassName("close")[2];

/**
 * When the user clicks the button, open the modal
 */
btn.onclick = function () {
    modal.style.display = "block";

}
registerBtn.onclick = function () {
    registerModal.style.display = "block";
}
fbBtn.onclick = function () {
    facebookModal.style.display = "block";
}

/**
 * WHen the user clicks on (X), close the modal
 */
span.onclick = function () {
    modal.style.display = "none";
}
registerSpan.onclick = function () {
    registerModal.style.display = "none";
}
facebookCLose.onclick = function () {
    facebookModal.style.display = "none";
}

/**
 * When the user clicks anywhere outside of the modal, close it
 */
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    if (event.target == registerModal) {
        registerModal.style.display = "none";
    }
    if (event.target == facebookModal) {
        facebookModal.style.display = "none";
    }
}

/**
 * When ESC is pressed, close modal
 */
document.addEventListener('keyup', function(e) {
    if (e.keyCode == 27) {
        modal.style.display = "none";
        registerModal.style.display = "none";

    }
});
/**
 * Created by joey on 2-2-17.
 */
