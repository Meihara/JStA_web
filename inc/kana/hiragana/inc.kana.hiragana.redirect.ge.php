<?php
session_start();
include "../../inc.connection.php";
$local = "ge";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
