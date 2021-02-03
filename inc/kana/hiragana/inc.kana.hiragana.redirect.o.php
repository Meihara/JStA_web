<?php
session_start();
include "../../inc.connection.php";
$local = "o";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
