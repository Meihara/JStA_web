<?php
session_start();
include "../../inc.connection.php";
$local = "pi";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
