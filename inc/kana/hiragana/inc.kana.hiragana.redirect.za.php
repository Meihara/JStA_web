<?php
session_start();
include "../../inc.connection.php";
$local = "za";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
