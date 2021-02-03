<?php
session_start();
include "../../inc.connection.php";
$local = "so";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
