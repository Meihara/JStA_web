<?php
session_start();
include "../../inc.connection.php";
$local = "u";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
