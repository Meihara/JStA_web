<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
$noteText = $_POST['noteText'];
$where = $_POST['noteID'];
$wasThere = $_POST['wasThere'];
$isThere = $_POST['isThere'];
$conn->writeUserNote($where, $noteText, $wasThere, $isThere);