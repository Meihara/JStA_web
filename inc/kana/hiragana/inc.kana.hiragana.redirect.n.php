<?php
session_start();
include "../../inc.connection.php";
$local = "n";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
