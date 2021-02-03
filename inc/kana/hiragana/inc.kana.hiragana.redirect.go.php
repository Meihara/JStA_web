<?php
session_start();
include "../../inc.connection.php";
$local = "go";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
