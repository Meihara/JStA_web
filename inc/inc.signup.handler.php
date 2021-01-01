<?php
include "inc.connection.php";
$conn = new Connection();

if (isset($_POST['username']) && isset($_POST['pw']) && isset($_POST['langSelect'])) {

    $user = $_POST['username'];
    $pwd = $_POST['pw'];
    $dLang = $_POST['langSelect'];
    /*echo $user;
    echo "<br>";
    echo $pwd;
    echo "<br>";
    echo $dLang;*/
    $conn->signup($user, $pwd, $dLang);
} 
else {

    header("Location: inc.signup.php");
}