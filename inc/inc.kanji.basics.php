<?php session_start();
include "inc.connection.php";
$conn = new Connection();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            $conn->kanjiBasicsAssembler();
        }
    }
else {
    header("Location: ../index.php");
}
?>