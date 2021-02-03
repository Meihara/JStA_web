<?php
session_start();
include "../../inc.connection.php";
$local = "ha";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
