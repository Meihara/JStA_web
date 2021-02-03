<?php
session_start();
include "../../inc.connection.php";
$local = "ba";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
