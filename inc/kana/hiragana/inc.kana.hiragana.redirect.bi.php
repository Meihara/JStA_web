<?php
session_start();
include "../../inc.connection.php";
$local = "bi";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
