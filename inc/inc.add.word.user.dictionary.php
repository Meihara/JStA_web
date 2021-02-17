<?php session_start();
include "inc.connection.php";
$conn = new Connection();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if(!empty($_POST['kana']) || !empty($_POST['romanized']) || !empty($_POST['meaning1']) || !empty($_POST['meaning2'])){
                $kana = $_POST['kana'];
                $romanized = $_POST['romanized'];
                $meaning1 = $_POST['meaning1'];
                $meaning2 = $_POST['meaning2'];
            $conn->yourDictionaryAddWord($kana, $romanized, $meaning1, $meaning2);
            }
            else{
                header("Location: inc.list.user.dictionary.php");
            }
        }
    }
else {
    /*require "static/common/static.common.login.required.php";*/
    header("Location: ../index.php");
}
?>