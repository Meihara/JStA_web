<?php
session_start();
include "../../inc.connection.php";
$local = "pu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
