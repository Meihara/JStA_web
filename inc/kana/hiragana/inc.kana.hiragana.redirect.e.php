<?php
session_start();
include "../../inc.connection.php";
$local = "e";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
