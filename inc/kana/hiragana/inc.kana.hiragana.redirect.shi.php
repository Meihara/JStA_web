<?php
session_start();
include "../../inc.connection.php";
$local = "shi";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
