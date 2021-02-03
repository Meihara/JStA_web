<?php
session_start();
include "../../inc.connection.php";
$local = "pa";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
