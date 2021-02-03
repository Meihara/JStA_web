<?php
session_start();
include "../../inc.connection.php";
$local = "sa";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
