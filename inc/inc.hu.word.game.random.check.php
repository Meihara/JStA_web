<?php
include "inc.connection.php";
$conn = new Connection();
if (!empty($_POST['answer'])){
require "inc.hu.word.random.check.redirect.php";
}
else{
echo "<!doctype html>
        <html>
        <head>
        <link rel='stylesheet' href='../assets/common.stylesheet.css'>
        <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
        </head>
        <body>";
            echo "<div align='center'>
            <h2>Ne hagyd a választ üresen!</h2>
            <br>
            <form action='../hu/subpages/hu.word.practice.random.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Következő!'>
            </form>
            </div>
            </body>
            </html>";
}