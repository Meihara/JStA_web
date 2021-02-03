<?php
session_start();
include "../../inc.connection.php";
$local = "hu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
