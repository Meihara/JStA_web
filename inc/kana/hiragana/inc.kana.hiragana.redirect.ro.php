<?php
session_start();
include "../../inc.connection.php";
$local = "ro";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
