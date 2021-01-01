<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 1){
            header("Location: ../hu/hu.dashboard.php");
            }
        }
    }
else {
    header("Location: ../index.php");
}
include "../inc/inc.connection.php";
$conn = new Connection();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/common.stylesheet.css">
    <link rel="shortcut icon" href="../Project-JStA/wip/logo/index_logo.png"/>
    <title>JStA Dashboard</title>
</head>
    
    <div align="center">
        <h2>Termek hozzaadasa:</h2>
        <br>
        <form action="../inc/insert.inc.php" name="addItem" method="post">
            <p>Az uj item neve: <input type="text" name="itemName" placeholder="Uj item.."></p>
            
            <p>Uj itembol rendelkezesre all: <input type="number" name="itemQT" placeholder="Mennyiseg" min="1" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"></p>
            <input type="submit" name="" value="Hozzaadas!">
        </form>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div align="center">
        <form action="../inc/inc.logout.php">
        <input type="submit" value="Log out!">
        </form>
    </div>
<body>
</body>
</html>