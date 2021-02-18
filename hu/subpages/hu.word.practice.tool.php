<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 0){
            header("Location: ../../en/en.word.practice.tool.php");
            }
        }
    }
include "../../inc/inc.connection.php";
$conn = new Connection();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/common.stylesheet.css">
    <link rel="shortcut icon" href="../../Project-JStA/wip/logo/index_logo.png"/>
    <title>JStA Szógyakorlás</title>
</head>
    <div align="center">
        <form action="hu.word.practice.random.php" name="doUKnowTheWord" method="post">
            <input class="actionButton2" type="submit" name="" value="Tudod a szót? (játék)">
        </form>
    </div>
    <div align="center">
        <form action="hu.dictionary.php" name="dictionary" method="post">
            <input class="actionButton1" type="submit" name="" value="Szótár">
        </form>
    </div>
    <div align="center">
        <form action="hu.hiragana.table.php" name="hiraganTable" method="post">
            <input class="actionButton1" type="submit" name="" value="Hiragana tábla">
        </form>
    </div>
    <br>
    <div align="center">
        <form action="../../inc/inc.user.dictionary.php" name="userDic" method="post">
            <input class="actionButton1" type="submit" name="" value="A te szótárad">
        </form>
    </div>
    <br>
    <div align="center">
        <form action="../../inc/inc.hu.guest.back.home.php">
        <input class="actionButton1" type="submit" value="Vissza">
        </form>
    </div>
<body>
</body>
</html>