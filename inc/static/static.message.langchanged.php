<?php
echo "<!doctype html>
        <html>
        <head>
        <link rel='stylesheet' href='../assets/common.stylesheet.css'>
        </head>
        <body>";
        if($_SESSION['lang'] == 0){
            echo "<div align='center'>
            <h2>Update was sucessful!</h2>
            <br>
            <form action='../index.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Next!'>
            </form>
            </div>
            </body>
            </html>";
        }
        else {
            echo "<div align='center'>
            <h2>Sikeres frissítés!</h2>
            <br>
            <form action='../index.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Tovább!'>
            </form>
            </div>
            <body>
            </html>";
        }