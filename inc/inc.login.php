<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == !true){
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
    <title>JStA Log In</title>
</head>
<body>
    <div align="center">
        <form action="inc.login.handler.php" name="signupForm" method="post">
            <input type="text" name="username" placeholder="Username">
            <br>
            <input type="password" name="pw" placeholder="Password">
            <br>
            <input class="loginSuButton1" type="submit" name="" value="Log In">
        </form>
    </div>
</body>
</html>