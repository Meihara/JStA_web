<?php
session_start();
include "../../inc.connection.php";
$local = "da";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
