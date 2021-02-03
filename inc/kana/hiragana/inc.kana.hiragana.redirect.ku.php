<?php
session_start();
include "../../inc.connection.php";
$local = "ku";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
