<?php
session_start();
include "../../inc.connection.php";
$local = "nu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
