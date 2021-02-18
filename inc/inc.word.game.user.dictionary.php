<?php session_start();
include "inc.connection.php";
$conn = new Connection();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            $conn->yourDictionaryWordGameRandom();
            }
        }
else {
    /*require "static/common/static.common.login.required.php";*/
    header("Location: ../index.php");
}
?>