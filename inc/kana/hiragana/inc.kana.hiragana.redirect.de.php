<?php
session_start();
include "../../inc.connection.php";
$local = "de";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
