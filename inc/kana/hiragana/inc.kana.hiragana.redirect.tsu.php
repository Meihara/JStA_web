<?php
session_start();
include "../../inc.connection.php";
$local = "tsu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
