<?php
session_start();
include "../../inc.connection.php";
$local = "re";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
