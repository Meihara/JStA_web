<?php
session_start();
include "../../inc.connection.php";
$local = "po";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
