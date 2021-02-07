<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 0){
            header("Location: ../../en/subpages/en.dictionary.php");
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
    <script src="../../scripts/back.js"></script>
<title>JStA Dictionary</title>
</head>
    <div align="center">
        <div align="center">
        <button class="actionButton1" onclick="goBackOne()">Vissza</button>
        </div>
    <table style="width:85%">
  <tr>
    <th><h2>Szám</h2></th>
    <th><h2>Hiragana</h2></th> 
    <th><h2>Ro-maji</h2></th>
    <th><h2>Jelentés 1</h2></th>
    <th><h2>Jelentés 2</h2></th>
  </tr>
        <?php require "../../inc/inc.hu.dictionary.fill.php"?>
</table>
    </div>
<body>
</body>
</html>