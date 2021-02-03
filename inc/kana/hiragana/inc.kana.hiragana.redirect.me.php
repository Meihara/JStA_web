<?php
session_start();
include "../../inc.connection.php";
$local = "me";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
