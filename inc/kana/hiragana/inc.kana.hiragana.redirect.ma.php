<?php
session_start();
include "../../inc.connection.php";
$local = "ma";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
