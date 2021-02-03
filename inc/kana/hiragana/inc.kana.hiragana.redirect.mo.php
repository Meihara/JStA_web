<?php
session_start();
include "../../inc.connection.php";
$local = "mo";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
