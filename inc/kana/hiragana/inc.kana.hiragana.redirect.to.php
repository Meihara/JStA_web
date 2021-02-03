<?php
session_start();
include "../../inc.connection.php";
$local = "to";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
