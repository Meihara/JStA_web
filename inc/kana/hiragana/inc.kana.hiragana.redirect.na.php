<?php
session_start();
include "../../inc.connection.php";
$local = "na";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
