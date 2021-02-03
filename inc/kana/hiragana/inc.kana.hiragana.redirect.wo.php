<?php
session_start();
include "../../inc.connection.php";
$local = "wo";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
