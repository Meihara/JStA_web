<?php
session_start();
include "../../inc.connection.php";
$local = "gi";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
