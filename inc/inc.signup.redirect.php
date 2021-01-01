<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 1){
            header("Location: ../hu/hu.dashboard.php");
            }
            else{
                header("Location: ../en/en.dashboard.php");
            }
        }
    }
else {
    header("Location: ../index.php");
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
</head>
<body>
    <div align="center">
        <form action="../index.php" name="loginForm" method="post">
            <p>
                Sikeres regisztráció, jelentkezz be a főoldalon!
                <br>
                Sucessful sign up, please log in on the homepage!
            </p>
            <input class="signupRedirectButton1" type="submit" name="" value="Kezdőlap/Homepage">
        </form>
    </div>
</body>
</html>