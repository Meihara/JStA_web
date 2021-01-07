<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
$conn->guestSessionEn();