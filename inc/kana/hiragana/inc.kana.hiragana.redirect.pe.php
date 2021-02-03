<?php
session_start();
include "../../inc.connection.php";
$local = "pe";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
