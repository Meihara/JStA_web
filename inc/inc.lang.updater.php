<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
if (isset($_POST['changeLang'])) {
    $langC = $_POST['changeLang'];
    $where = $_SESSION["userID"];
    $conn->updateLang($langC, $where);
    } 
else {
    if($_SESSION['lang'] == 0){
    header("Location: ../en/subpages/en.user.settings.php");
    }
    else {
    header("Location: ../hu/subpages/hu.user.settings.php");
    }
}