<?php
session_start();
include "../../inc.connection.php";
$local = "ji";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
