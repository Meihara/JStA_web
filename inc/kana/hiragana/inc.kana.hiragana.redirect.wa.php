<?php
session_start();
include "../../inc.connection.php";
$local = "wa";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
