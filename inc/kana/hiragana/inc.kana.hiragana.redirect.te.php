<?php
session_start();
include "../../inc.connection.php";
$local = "te";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
