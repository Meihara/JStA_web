<?php
session_start();
include "../../inc.connection.php";
$local = "ni";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
