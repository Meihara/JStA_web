<?php
session_start();
include "../../inc.connection.php";
$local = "ho";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
