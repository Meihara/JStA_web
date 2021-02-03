<?php
session_start();
include "../../inc.connection.php";
$local = "ra";
$conn = new Connection();
$conn->hiraganaSubPageAssembler($local);
