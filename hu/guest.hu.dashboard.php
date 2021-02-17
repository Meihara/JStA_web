<?php
session_start();
include "../inc/inc.connection.php";
$conn = new Connection();
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/common.stylesheet.css">
    <link rel="shortcut icon" href="../Project-JStA/wip/logo/index_logo.png"  />
    <title>-Vendég- JStA Irányítópult</title>
</head>
    <div align="center">
        <form action="subpages/hu.word.practice.tool.php" name="userSettings" method="post">
            <input class="actionButton2" type="submit" name="" value="Szavak gyakorlása">
        </form>
    </div>
    <div align="center">
        <form action="../inc/static/common/static.common.login.required.php" name="kanjiPractice" method="post">
            <input class="actionButton2" type="submit" name="" value="Kanji tanulása">
        </form>
    </div>
    <div align="center">
    <form action="../inc/inc.signup.php" name="signUpForm" method="post">
            <input class="actionButton2" type="submit" name="" value="Regisztrálás">
        </form>
    </div>
    <br>
    <div align="center">
    <form action="../index.php" name="signUpForm" method="post">
            <input class="actionButton2" type="submit" name="" value="Vissza a kezdőlapra">
        </form>
    </div>
    
<body>
</body>
</html>