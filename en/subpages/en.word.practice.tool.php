<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 1){
            header("Location: ../../hu/hu.word.practice.tool.php");
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
    <title>JStA Word practice</title>
</head>
    <div align="center">
        <form action="en.word.practice.random.php" name="doUKnowTheWord" method="post">
            <input class="actionButton2" type="submit" name="" value="Do you know the word? (game)">
        </form>
    </div>
    <div align="center">
        <form action="en.dictionary.php" name="dictionary" method="post">
            <input class="actionButton1" type="submit" name="" value="Dictionary">
        </form>
    </div>
    <div align="center">
        <form action="en.hiragana.table.php" name="hiraganTable" method="post">
            <input class="actionButton1" type="submit" name="" value="Hiragana table">
        </form>
    </div>
    <br>
    <div align="center">
        <form action="../../inc/inc.user.dictionary.php" name="hiraganTable" method="post">
            <input class="actionButton1" type="submit" name="" value="Your dictionary">
        </form>
    </div>
    <br>
    <div align="center">
        <form action="../../inc/inc.en.guest.back.home.php">
        <input class="actionButton1" type="submit" value="Back">
        </form>
    </div>
<body>
</body>
</html>