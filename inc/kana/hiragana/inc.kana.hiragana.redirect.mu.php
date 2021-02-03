<?php
session_start();
include "../../inc.connection.php";
$local = "mu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
