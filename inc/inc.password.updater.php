<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
if (isset($_POST['username']) && isset($_POST['pwOld']) && isset($_POST['pwNew'])) {
    $uid = $_POST['username'];
    $pwOld = $_POST["pwOld"];
    $pwNew = $_POST['pwNew'];
    $conn->updatePassword($uid, $pwOld, $pwNew);
    } 
else {
    if($_SESSION['lang'] == 0){
    header("Location: ../en/subpages/en.user.settings.php");
    }
    else {
    header("Location: ../hu/subpages/hu.user.settings.php");
    }
}