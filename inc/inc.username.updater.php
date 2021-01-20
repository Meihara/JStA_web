<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
if (!empty($_POST['uidOld']) && !empty($_POST['uidNew']) && !empty($_POST['pw'])) {
    $uidOld = $_POST['uidOld'];
    $uidNew = $_POST["uidNew"];
    $pw = $_POST['pw'];
    if($uidOld == $_SESSION['user']){
    $conn->updateUsername($uidOld, $uidNew, $pw);
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