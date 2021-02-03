<?php
session_start();
include "../../inc.connection.php";
$local = "yo";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
