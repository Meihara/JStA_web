<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 1){
            header("Location: ../../en/en.word.practice.random.php");
            }
        }
    }
include "../../inc/inc.connection.php";
$conn = new Connection();
require "../../inc/inc.en.word.game.random.php";
?>