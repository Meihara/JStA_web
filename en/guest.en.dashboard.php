<?php
include "../inc/inc.connection.php";
$conn = new Connection();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/common.stylesheet.css">
    <link rel="shortcut icon" href="../Project-JStA/wip/logo/index_logo.png"  />
    <title>-GUEST- JStA Dashboard</title>
</head>
    <div align="center">
        <form action="subpages/en.word.practice.tool.php" name="userSettings" method="post">
            <input class="actionButton2" type="submit" name="" value="Word practice tool">
        </form>
    </div>
    <div align="center">
    <form action="../inc/inc.signup.php" name="signUpForm" method="post">
            <input class="actionButton2" type="submit" name="" value="Sign up">
        </form>
    </div>
<body>
</body>
</html>