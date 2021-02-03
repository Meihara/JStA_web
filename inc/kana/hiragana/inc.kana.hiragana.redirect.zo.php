<?php
session_start();
include "../../inc.connection.php";
$local = "zo";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
