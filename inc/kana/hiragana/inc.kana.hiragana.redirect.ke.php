<?php
session_start();
include "../../inc.connection.php";
$local = "ke";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
