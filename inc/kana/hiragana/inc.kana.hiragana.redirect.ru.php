<?php
session_start();
include "../../inc.connection.php";
$local = "ru";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
