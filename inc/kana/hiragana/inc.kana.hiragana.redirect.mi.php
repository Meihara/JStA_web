<?php
session_start();
include "../../inc.connection.php";
$local = "mi";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
