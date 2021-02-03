<?php
session_start();
include "../../inc.connection.php";
$local = "zu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
