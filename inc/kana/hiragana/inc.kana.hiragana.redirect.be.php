<?php
session_start();
include "../../inc.connection.php";
$local = "be";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
