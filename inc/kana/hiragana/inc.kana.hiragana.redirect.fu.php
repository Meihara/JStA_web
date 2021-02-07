<?php
session_start();
include "../../inc.connection.php";
$local = "fu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
