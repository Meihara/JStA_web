<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 0){
            header("Location: ../../en/subpages/en.kanji.tools.php");
            }
        }
    }
else {
    header("Location: ../../index.php");
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
    <title>JStA Kanji eszközök</title>
</head>
    <div align="center">
        <form action="../../inc/inc.kanji.basics.php" name="basicsKanji" method="post">
            <input class="actionButton2" type="submit" name="" value="Kanji alapok">
        </form>
    </div>
    <div align="center">
        <form action="../../inc/inc.kanji.list.php" name="listKanji" method="post">
            <input class="actionButton2" type="submit" name="" value="Kanji lista">
        </form>
    </div>
    <br>
    <div align="center">
        <form action="../hu.dashboard.php" name="back" method="post">
            <input class="actionButton1" type="submit" name="" value="Vissza">
        </form>
    </div>
    <p class="disclaimerFormat1">Az itt megjelenő információk javarészt az Eriko Sato<br>által írt <i>Learn Japanese Kanji Practice Book volume 1</i> című könyvből származik.<br>Amennyiben hasznosnak találod, amit itt láttál, mindenképpen vess egy pillantást a könyvre is. (ISBN: 978-0-8048-4493-2)</p>
<body>
</body>
</html>