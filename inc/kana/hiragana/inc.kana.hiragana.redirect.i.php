<?php
session_start();
include "../../inc.connection.php";
$local = "i";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
