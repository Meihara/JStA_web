<?php
session_start();
include "../../inc.connection.php";
$local = "ze";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
