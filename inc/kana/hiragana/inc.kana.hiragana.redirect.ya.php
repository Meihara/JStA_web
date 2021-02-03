<?php
session_start();
include "../../inc.connection.php";
$local = "ya";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
