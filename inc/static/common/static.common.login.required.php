<?php
echo "<!doctype html>
        <html>
        <head>
        <link rel='stylesheet' href='../../../assets/common.stylesheet.css'>
        <link rel='shortcut icon' href='../../../Project-JStA/wip/logo/index_logo.png'/>
        <script src='../../scripts/back.js'></script>
        </head>
        <body>";
        echo "<div align='center'>
            <h2>Ehhez a funkcióhoz felhasználói fiók szükséges!</h2>
            </div>";
        echo "<div align='center'>
            <h2>An account already uses this name!</h2>
            <br>
            <form action='../../inc.login.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Log in'>
            </form>
            <form action='../../inc.signup.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Register'>
            </form>
            <form action='goBackOne()' method='get'>
                <input class='actionButton1' type='submit' name='' value='Back/Vissza'>
            </form>
            </div>
            </body>
            </html>";