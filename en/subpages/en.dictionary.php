<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 1){
            header("Location: ../../hu/subpages/hu.dictionary.php");
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
        <button class="actionButton1" onclick="goBackOne()">Back</button>
    </div>
    <div align="center">
    <table style="width:85%">
  <tr>
    <th><h2>Number</h2></th>
    <th><h2>Hiragana</h2></th> 
    <th><h2>Ro-maji</h2></th>
    <th><h2>Meaning 1</h2></th>
    <th><h2>Meaning 2</h2></th>
  </tr>
        <?php require "../../inc/inc.en.dictionary.fill.php"?>
</table>
    </div>
<body>
</body>
</html>