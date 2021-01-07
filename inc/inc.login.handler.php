<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
if (isset($_POST['username']) && isset($_POST['pw'])) {

    $user = $_POST['username'];
    $pwd = $_POST['pw'];

    $conn->login($user, $pwd);
    
} else {

    header("Location: static/common/static.common.login.failed.php");
}

