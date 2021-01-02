<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 1){
            header("Location: ../../hu/subpages/hu.user.settings.php");
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/common.stylesheet.css">
    <link rel="shortcut icon" href="../../Project-JStA/wip/logo/index_logo.png"/>
    <title>JStA Dashboard</title>
</head>
    
    <div align="center">
        <h2>Your prefered language English.</h2>
        <h3>If you wish to change it, please select a new language and press update.</h3>
        <form action="../../inc/inc.lang.updater.php" name="userSettingsLang" method="post">
            <select class="signupLangSelect1" name='changeLang' size="1">
            <option value='' disabled selected>---</option>
            <option value="0">English</option>
            <option value="1">Magyar</option>
            </select>
            <br>
            <input class="actionButton1" type="submit" name="" value="Update!">
            <br>
            <input class="hiddenInput" type="text" name="page" value="../en/subpages/en.user.settings.php">
        </form>
    </div>
    <div align="center">
        <h2>Change your password!</h2>
        <h3>If you wish to change it, enter your username as well as your previous password<br>and a new password, then press the Update button below.</h3>
        <form action="../../inc/inc.password.updater.php" name="userSettingsPw" method="post">
            <input type="text" name="username" placeholder="Username">
            <br>
            <input type="password" name="pwOld" placeholder="Old password">
            <br>
            <input type="password" name="pwNew" placeholder="New password">
            <br>
            <input class="actionButton1" type="submit" name="" value="Update!">
        </form>
    </div>
    <br>
<body>
</body>
</html>