<?php
session_start();
include "../../inc.connection.php";
$local = "ki";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
