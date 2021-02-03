<?php
session_start();
include "../../inc.connection.php";
$local = "ga";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
