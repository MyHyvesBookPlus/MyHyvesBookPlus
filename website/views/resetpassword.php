<!DOCTYPE html>
<html>
<head>
    <style>
        @import url(styles/main.css);
        @import url(styles/settings.css);
        @import url(styles/resetpassword.css);
    </style>
</head>
<body>
<div class='password-change'>
    <div class="top-logo"><img src="img/top-logo.png" alt="MyHyvesbook+"/></div>

    <form class='settings platform item-box' method='post'>
        <h5>Voer een nieuw wachtwoord in</h5>
        <input type="hidden"
               name="u"
               value="<?=$_GET["u"]?>"
        >
        <input type="hidden"
               name="h"
               value="<?=$_GET["h"]?>"
        >
        <ul>
            <li>
                <label>Nieuw wachtwoord</label>
                <input type='password'
                       name='password'
                       placeholder='Nieuw wachtwoord'
                >
            </li>
            <li>
                <label>Bevestig wachtwoord</label>
                <input type='password'
                       name='password-confirm'
                       placeholder='Bevestig wachtwoord'
                >
            </li>
            <li>
                <label></label>
                <button type='submit'>Verander wachtwoord</button>
            </li>
        </ul>
    </form>
</div>
</body>
</html>