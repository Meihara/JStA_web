<?php
session_start();
include "../../inc.connection.php";
$local = "ka";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
