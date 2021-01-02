<?php
echo "<!doctype html>
        <html>
        <head>
        <link rel='stylesheet' href='../assets/common.stylesheet.css'>
        <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
        </head>
        <body>";
        if($langL == 0){
            echo "<div align='center'>
            <h2>Failed to update password!</h2>
            <h3>Username or password not correct! <br>Please try again.</h3>
            <br>
            <form action='../en/subpages/en.user.settings.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='OK'>
            </form>
            </div>
            </body>
            </html>";
        }
        else {
            echo "<div align='center'>
            <h2>Jelszófrissítés sikertelen!</h2>
            <h3>Felhasználónév vagy jelszó téves!<br>Próbáld újra.</h3>
            <br>
            <form action='../hu/subpages/hu.user.settings.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='OK'>
            </form>
            </div>
            <body>
            </html>";
        }