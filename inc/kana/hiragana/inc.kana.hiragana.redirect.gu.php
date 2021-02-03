<?php
session_start();
include "../../inc.connection.php";
$local = "gu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
