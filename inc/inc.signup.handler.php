<?php
include "inc.connection.php";
$conn = new Connection();

if (isset($_POST['username']) && isset($_POST['pw']) && isset($_POST['langSelect'])) {

    $user = $_POST['username'];
    $pwd = $_POST['pw'];
    $dLang = $_POST['langSelect'];
    if($dLang == '0' || $dLang == '1'){
        $conn->signup($user, $pwd, $dLang);
    }
    else{
    require "static/common/static.common.message.troll.php";
    }
} 
else {

    header("Location: inc.signup.php");
}