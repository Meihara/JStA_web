<?php
session_start();
include "../../inc.connection.php";
$local = "no";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
