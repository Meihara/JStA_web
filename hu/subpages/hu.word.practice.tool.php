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
        <form action="subpages/en.word.practice.tool.php" name="userSettings" method="post">
            <input class="actionButton2" type="submit" name="" value="Word practice tool">
        </form>
    </div>
    <div align="center">
        <form action="hu.dictionary.php" name="userSettings" method="post">
            <input class="actionButton1" type="submit" name="" value="Szótár">
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