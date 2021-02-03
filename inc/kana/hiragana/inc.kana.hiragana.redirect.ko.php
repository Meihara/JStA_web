<?php
session_start();
include "../../inc.connection.php";
$local = "ko";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
