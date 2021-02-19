<?php
session_start();
include "inc.connection.php";
$conn = new Connection();
$noteText = $_POST['noteText'];
$where = $_POST['noteID'];
$wasThere = $_POST['wasThere'];
$isThere = $_POST['isThere'];
if(!empty($noteText)){
    $conn->writeUserNote($where, $noteText, $wasThere, $isThere);
}
else{
    header("Location: kana/hiragana/inc.kana.hiragana.redirect.".$wasThere.".php");
}