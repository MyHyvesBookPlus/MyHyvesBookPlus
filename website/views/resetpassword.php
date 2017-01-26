<?php
function passwordResetFields() {
    $username = $_GET['u'];
    $hash = $_GET['h'];
    $content ="
    <form class='settings' method = 'post' >
        <h5 > Voer een nieuw wachtwoord in </h5 >
        <input type = 'hidden'
               name = 'u'
               value = '$username'
                   >
        <input type = 'hidden'
               name = 'h'
               value = '$hash'
                   >
        <ul >
            <li >
                <label > Nieuw wachtwoord </label >
                <input type = 'password'
                       name = 'password'
                       placeholder = 'Nieuw wachtwoord'
                           >
            </li >
            <li >
                <label > Bevestig wachtwoord </label >
                <input type = 'password'
                       name = 'password-confirm'
                       placeholder = 'Bevestig wachtwoord'
                           >
            </li >
            <li >
                <label ></label >
                <button type = 'submit' > Verander wachtwoord </button >
            </li >
        </ul >
    </form >";
    return $content;
}