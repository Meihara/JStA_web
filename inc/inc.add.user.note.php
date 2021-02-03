<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
$noteWhere = $_POST['noteValue'];
$conn->readUserNote($noteWhere);