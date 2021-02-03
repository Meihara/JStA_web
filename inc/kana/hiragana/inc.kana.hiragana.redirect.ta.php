<?php
session_start();
include "../../inc.connection.php";
$local = "ta";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
