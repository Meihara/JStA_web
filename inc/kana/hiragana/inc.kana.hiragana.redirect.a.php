<?php
session_start();
include "../../inc.connection.php";
$local = "a";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
