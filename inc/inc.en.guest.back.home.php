<?php
session_start();
    if(isset($_SESSION["logged-in"])){
        header("Location: ../en/en.dashboard.php");
    }
else {
    header("Location: ../en/guest.en.dashboard.php");
}