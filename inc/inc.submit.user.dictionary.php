<?php session_start();
include "inc.connection.php";
$conn = new Connection();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if(!empty($_POST['dicName'])){
                $nameOfTable = $_POST['dicName'];
            $conn->yourDictionarySubmit($nameOfTable);
            }
            else{
                header("Location: inc.create.user.dictionary.php");
            }
        }
    }
else {
    /*require "static/common/static.common.login.required.php";*/
    header("Location: ../index.php");
}
?>