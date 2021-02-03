<?php
session_start();
include "../../inc.connection.php";
$local = "dzu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
