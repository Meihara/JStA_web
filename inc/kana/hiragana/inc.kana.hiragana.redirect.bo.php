<?php
session_start();
include "../../inc.connection.php";
$local = "bo";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
