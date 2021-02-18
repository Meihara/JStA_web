<?php session_start();
include "inc.connection.php";
$conn = new Connection();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if(!empty($_POST['answer'])){
                $where = $_POST['truth1'];
                $ans = $_POST['answer'];
                $meth = $_POST['methode'];
                $conn->yourDictionaryWordGameCheck($where, $ans, $meth);
            }
        else{
            header("Location: inc.word.game.user.dictionary.php");
        }
        }
    }
else {
    /*require "static/common/static.common.login.required.php";*/
    header("Location: ../index.php");
}
?>