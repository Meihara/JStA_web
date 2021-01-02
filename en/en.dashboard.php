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
        <form action="subpages/en.user.settings.php" name="userSettings" method="post">
            <input class="actionButton1" type="submit" name="" value="User settings">
        </form>
    </div>
    <br>
    <div align="center">
        <form action="../inc/inc.logout.php">
        <input class="actionButton1" type="submit" value="Log out!">
        </form>
    </div>
<body>
</body>
</html>