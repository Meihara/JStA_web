<?php
session_start();
include "../../inc.connection.php";
$local = "do";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
