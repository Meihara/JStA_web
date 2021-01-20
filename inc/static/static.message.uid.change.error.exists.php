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
            <h2>Update failed!</h2>
            <br>
			<h3>This username is already in use!</h3>
            <form action='../index.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Next!'>
            </form>
            </div>
            </body>
            </html>";
        }
        else {
            echo "<div align='center'>
            <h2>Sikertelen frissítés!</h2>
            <br>
			<h3>Ez a felhasználónév már használatban van!</h3>
            <form action='../index.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Tovább!'>
            </form>
            </div>
            <body>
            </html>";
        }