<?php
session_start();
include "../../inc.connection.php";
$local = "bu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
