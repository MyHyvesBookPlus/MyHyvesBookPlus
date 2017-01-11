<!DOCTYPE html>
<html>
    <?php
        include("views/head.php");
    ?>
    <body>
        <?php
            /*
             * This view adds the main layout over the screen.
             * Header, menu, footer.
             */
             include("views/main.php");

            /* Add your view files here. */
            include("views/chat.php");
        ?>
    </body>
</html>
