<?php
session_start();
include "../../inc.connection.php";
$local = "he";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
