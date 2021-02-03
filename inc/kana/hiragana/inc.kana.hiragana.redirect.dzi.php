<?php
session_start();
include "../../inc.connection.php";
$local = "dzi";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
