<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == true){
            header("Location: en.dashboard.php");
            }
            else {
            header("Location: hu.dashboard.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/common.stylesheet.css">
    <link rel="shortcut icon" href="Project-JStA/wip/logo/index_logo.png" />
    <title>Project JStA</title>
</head>
<body>
    <div align="center">
        <img src="Project-JStA/wip/logo/jsta_logo_v1-4_croped.png" class="logo">
        <form action="inc/inc.login.php" name="loginForm" method="post">
            <input class="indexButton1" type="submit" name="" value="Log In">
        </form>
        <form action="inc/inc.signup.php" name="signUpForm" method="post">
            <input class="indexButton1" type="submit" name="" value="Sign Up">
        </form>
        <h1>Folytatás vendégként/Continue as guest</h1>
        <form action="guest.hu.dashboard.php" name="guest" method="post">
            <input class="indexButton1" type="submit" name="" value="Magyar">
        </form>
        <form action="guest.en.dashboard.php" name="guest" method="post">
            <input class="indexButton1" type="submit" name="" value="English">
        </form>
    </div>
</body>
</html>