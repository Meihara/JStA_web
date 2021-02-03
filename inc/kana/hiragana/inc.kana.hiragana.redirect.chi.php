<?php
session_start();
include "../../inc.connection.php";
$local = "chi";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
