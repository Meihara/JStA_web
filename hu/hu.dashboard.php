<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 0){
            header("Location: ../en/en.dashboard.php");
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
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/common.stylesheet.css">
    <link rel="shortcut icon" href="../Project-JStA/wip/logo/index_logo.png"  />
    <title>JStA Irányítópult</title>
</head>
        <div align="center">
        <form action="subpages/hu.word.practice.tool.php" name="userSettings" method="post">
            <input class="actionButton2" type="submit" name="" value="Szavak gyakorlása">
        </form>
    </div>
    <div align="center">
        <form action="subpages/hu.user.settings.php" name="userSettings" method="post">
            <input class="settingsButtonHu" type="submit" name="" value="Felhasználói beállítások">
        </form>
    </div>
    <br>
    <div align="center">
        <form action="../inc/inc.logout.php">
        <input class="actionButton1" type="submit" value="Kijelentkezés!">
        </form>
    </div>
<body>
</body>
</html>