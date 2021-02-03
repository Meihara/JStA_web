<?php
session_start();
include "../../inc.connection.php";
$local = "ri";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
