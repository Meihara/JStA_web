<?php
include "inc.connection.php";
$conn = new Connection();
if (!empty($_POST['answer'])){
require "inc.en.word.random.check.redirect.php";
}
else {
    echo "<!doctype html>
        <html>
        <head>
        <link rel='stylesheet' href='../assets/common.stylesheet.css'>
        <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
        </head>
        <body>";
            echo "<div align='center'>
            <h2>Do not leave the answer field empty!</h2>
            <br>
            <form action='../en/subpages/en.word.practice.random.php' method='get'>
                <input class='actionButton1' type='submit' name='' value='Next!'>
            </form>
            </div>
            </body>
            </html>";
}