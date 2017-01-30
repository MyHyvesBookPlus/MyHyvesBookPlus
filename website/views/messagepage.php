<?php 
function messagePage(string $content) {
    $webpage = ("
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            @import url(../styles/main.css);
            @import url(../styles/settings.css);
            @import url(../styles/message-page.css);
        </style>
    </head>
    <body>
    <div class='password-change'>
        <div class='top-logo'><a href='../index.php'><img src='../img/top-logo.png' alt='MyHyvesbook+'/></a></div>
        <div class='item-box platform'>$content</div>
    </div>
    </body>
    </html>
    ");

    echo $webpage;
    }