<?php
session_start();
include "../../inc.connection.php";
$local = "se";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
