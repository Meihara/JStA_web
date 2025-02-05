<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 0){
            header("Location: ../en/en.dashboard.php");
            }
            else {
            header("Location: ../hu/hu.dashboard.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/common.stylesheet.css">
    <link rel="shortcut icon" href="Project-JStA/wip/logo/index_logo.png" />
<title>JStA Sign Up</title>
<script src="../scripts/jQueryAssets/SpryDOMUtils.js"></script>
<script src="../scripts/inc.js"></script>
</head>
<body>
    <div align="center">
        <form action="inc.signup.handler.php" name="loginForm" method="post">
            <input name="username" type="text" id="input1" placeholder="Username" onkeyup="valid(this)" onblur="valid(this)" maxlength="36">
            <br>
            <input type="password" name="pw" placeholder="Password" maxlength="36">
            <br>
            <p>
                UI language/Felhasználói felület nyelve:
                <br>
                (Can be changed later/Később változtatható)
            </p>
            <select class="signupLangSelect1" name='langSelect' size="1">
            <option value='' disabled selected>---</option>
            <option value="0">English</option>
            <option value="1">Magyar</option>
            </select>
            <br>
            <input class="loginSuButton1" type="submit" name="" value="Sign Up">
        </form>
    </div>
</body>
</html>