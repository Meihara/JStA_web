<?php
session_start();
include "../../inc.connection.php";
$local = "yu";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
