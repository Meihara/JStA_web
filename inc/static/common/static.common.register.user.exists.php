<?php
echo "<!doctype html>
        <html>
        <head>
        <link rel='stylesheet' href='../../../assets/common.stylesheet.css'>
        <link rel='shortcut icon' href='../../../Project-JStA/wip/logo/index_logo.png'/>
        </head>
        <body>";
        echo "<div align='center'>
            <h2>Már létezik felhasználó ezzel a névvel!</h2>
            </div>";
        echo "<div align='center'>
            <h2>An account already uses this name!</h2>
            <br>
            <form action='../../inc.login.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Log in'>
            </form>
            <form action='../../../index.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Homepage'>
            </form>
            </div>
            </body>
            </html>";