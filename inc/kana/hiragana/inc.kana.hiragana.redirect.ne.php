<?php
session_start();
include "../../inc.connection.php";
$local = "ne";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
