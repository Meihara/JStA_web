<?php
session_start();
include "../../inc.connection.php";
$local = "su";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
