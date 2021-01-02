<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
if (!empty($_POST['username']) && !empty($_POST['pwOld']) && !empty($_POST['pwNew'])) {
    $uid = $_POST['username'];
    $pwOld = $_POST["pwOld"];
    $pwNew = $_POST['pwNew'];
    if($uid == $_SESSION['user']){
    $conn->updatePassword($uid, $pwOld, $pwNew);
    }
    else{
        if($_SESSION['lang'] == 0){
        header("Location: ../en/subpages/en.user.settings.php");
        }
        else {
        header("Location: ../hu/subpages/hu.user.settings.php");
        }
    }
}
else {
    if($_SESSION['lang'] == 0){
    header("Location: ../en/subpages/en.user.settings.php");
    }
    else {
    header("Location: ../hu/subpages/hu.user.settings.php");
    }
}