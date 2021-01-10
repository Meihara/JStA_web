<?php
session_start();
    if(isset($_SESSION["logged-in"])){
        header("Location: ../hu/hu.dashboard.php");
    }
else {
    header("Location: ../hu/guest.hu.dashboard.php");
}