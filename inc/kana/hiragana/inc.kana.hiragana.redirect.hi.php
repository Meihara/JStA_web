<?php
session_start();
include "../../inc.connection.php";
$local = "hi";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
