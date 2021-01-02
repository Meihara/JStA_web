<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
if (isset($_POST['changeLang'])) {
    $langC = $_POST['changeLang'];
    $where = $_SESSION["userID"];
    if($langC == '0' || $langC == '1'){
        $conn->updateLang($langC, $where);
        //require "static/static.message.troll.php";
    }
    else{
    require "static/static.message.troll.php";
    //$conn->updateLang($langC, $where);
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