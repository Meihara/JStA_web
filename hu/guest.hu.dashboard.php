<?php
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
        <h2>Termek hozzaadasa:</h2>
        <br>
        <form action="../inc/insert.inc.php" name="addItem" method="post">
            <p>Az uj item neve: <input type="text" name="itemName" placeholder="Uj item.."></p>
            
            <p>Uj itembol rendelkezesre all: <input type="number" name="itemQT" placeholder="Mennyiseg" min="1" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"></p>
            <input type="submit" name="" value="Hozzaadas!">
        </form>
    </div>
    <div align="center">
    <h2>Itemek modositasa:</h2>
        <form action="../inc/modify.inc.php" name="updateItem" method="post">
            <select name='selection' size="1">
            <?php
                require "../inc/container.inc.php";
            ?>
            </select>
            <br>
            <input type="number" placeholder="Uj mennyiseg" name="itemQT" min="1" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
            <br>
            <input type="submit" value="Item modositasa!">
        </form>
    </div>
    <div align="center">
    <h2>Itemek torlese:</h2>
        <form action="../inc/delete.inc.php" name="updateItem" method="post">
            <select name='selection' size="1">
            <?php
                require "../inc/container.inc.php";
            ?>
            </select>
            <input type="submit" value="Item torlese!">
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