<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 0){
            header("Location: ../../en/subpages/en.user.settings.php");
            }
        }
    }
else {
    header("Location: ../index.php");
}
include "../../inc/inc.connection.php";
$conn = new Connection();
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/common.stylesheet.css">
    <link rel="shortcut icon" href="../../Project-JStA/wip/logo/index_logo.png"/>
    <title>JStA Dashboard</title>
</head>
    
    <div align="center">
        <h2>Az alapértelmezett nyelved Magyar.</h2>
        <h3>Amennziben szeretnéd megváltoztatni, kérlek válassz új nyelvet, és kattints a Frissítés gombra.</h3>
        <form action="../../inc/inc.lang.updater.php" name="userSettings" method="post">
            <select class="signupLangSelect1" name='changeLang' size="1">
            <option value='' disabled selected>---</option>
            <option value="0">English</option>
            <option value="1">Magyar</option>
            </select>
            <br>
            <input class="actionButton1" type="submit" name="" value="Frissítés!">
        </form>
    </div>
        <div align="center">
        <h2>Jelszó megváltoztatása!</h2>
        <h3>Amennyiben meg kívánod változtatni a jelszavadat, ird be a felhasználóneved, régi jelszavad,<br> és új jelszavad, majd kattints a Frissítés gombra!</h3>
        <form action="../../inc/inc.password.updater.php" name="userSettingsPw" method="post">
            <input type="text" name="username" placeholder="Felhasználónév">
            <br>
            <input type="password" name="pwOld" placeholder="Régi jelszó">
            <br>
            <input type="password" name="pwNew" placeholder="Új jelszó">
            <br>
            <input class="actionButton1" type="submit" name="" value="Frissítés!">
        </form>
    </div>
    <br>
<body>
</body>
</html>