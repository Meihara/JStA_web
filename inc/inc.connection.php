<?php

class Connection {
    
    function connect(){
        $conn = new mysqli("localhost", "root", "", "jsta_database") or die("Couldn't establish connection!");
        return $conn;
    }
    
    function signup($uid, $pwd, $dLang){
        $conn = $this->connect();
        $userExistsSql = "SELECT name FROM users WHERE name='$uid'";
        $result = $conn->query($userExistsSql);
        if(mysqli_num_rows($result) > 0){

            header("Location: static/common/static.common.register.user.exists.php");
        }
        else{
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, pw, prefLang) VALUES('$uid', '$hash', '$dLang')";
            $conn->query($sql);
            header("Location: inc.signup.redirect.php");
            }
        //echo $uid."<br>".$pwd."<br>".$dLang."<br>".$userExistsSql;
        }
    
    function login($user, $pwd){
        $conn = $this->connect();
        
        $sql = "SELECT id, name, pw, prefLang FROM users WHERE name='$user'";

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {

            $hashedPwd = $row['pw'];
            $_SESSION["user"] = $row['name'];
            $_SESSION["userID"] = $row['id'];
            $_SESSION["lang"] = $row['prefLang'];
        }

        if (password_verify($pwd, $hashedPwd)) {

            $_SESSION["logged-in"] = true;
            if ($_SESSION["lang"]==0){
                header("Location: ../en/en.dashboard.php");
            }
            else {
                header("Location: ../hu/hu.dashboard.php");
            }
        } else {

            header("Location: static/common/static.common.login.failed.php");
        }
    }
    
    function updateLang($langC, $where) {
        $conn = $this->connect();
        $sql = "UPDATE users SET prefLang = ".$langC." WHERE id = ".$where."";
        $conn->query($sql);
        $_SESSION['lang'] = $langC;
        require "static/static.message.langchanged.php";
    
    }
    
    function updatePassword($uid, $pwOld, $pwNew) {
        $conn = $this->connect();
        $langL = $_SESSION['lang'];
        $sqlVerify = "SELECT id, name, pw, prefLang FROM users WHERE name='$uid'";
        $result = $conn->query($sqlVerify);
        while ($row = $result->fetch_assoc()) {
            $hashedPwd = $row['pw'];
            $where = $row['id'];
        }
        if (password_verify($pwOld, $hashedPwd)) {
            $hash = password_hash($pwNew, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET pw = '$hash' WHERE name = '$uid'";
            $conn->query($sql);
            //$langL = $_SESSION['lang'];
            session_unset();
            session_destroy();
            require "static/static.message.pwchanged.php";
        }
        else {
            require "static/static.message.pwchange.failed.php";
        }
         
    }
	
	function updateUsername($uidOld, $uidNew, $pw) {
		$conn = $this->connect();
		$langL = $_SESSION['lang'];
		$sqlCheckNameExists = "SELECT id, name, pw, prefLang FROM users WHERE name='$uidNew'";
		$result = $conn->query($sqlCheckNameExists);
        if(mysqli_num_rows($result) > 0){
            require "static/static.message.uid.change.error.exists.php";
		}
		else{
			$sqlVerify = "SELECT id, name, pw, prefLang FROM users WHERE name='$uidOld'";
        	$result = $conn->query($sqlVerify);
        	while ($row = $result->fetch_assoc()) {
            	$hashedPwd = $row['pw'];
            	$where = $row['id'];
        	}
        	if (password_verify($pw, $hashedPwd)) {
            	$sql = "UPDATE users SET name = '$uidNew' WHERE id = '$where'";
            	$conn->query($sql);
            	//$langL = $_SESSION['lang'];
            	session_unset();
            	session_destroy();
            	require "static/static.message.uidchanged.php";
        	}
			else {
            	require "static/static.message.uidchange.failed.php";
        	}
		}
	}
    
    function dictionaryFillEn() {
        $conn = $this->connect();
        $sql = "SELECT * FROM words";
        $output = ' ';
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<tr class="lineHIghlight"><th>'.$row['id_word'].'</th><th class="th1">'.$row['kana_w'].'</th><th class="th1">'.$row['roman_w'].'</th>';
            if($row['eng_w'] == $row['eng2_w']){
                $output .= '<th class="th1">'.$row['eng_w'].'</th><th class="th1">---</th></tr>';
            }
            else {
                $output .= '<th class="th1">'.$row['eng_w'].'</th><th class="th1">'.$row['eng2_w'].'</th></tr>' ;   
            }
            }
        echo $output;
    }
    
    function dictionaryFillHu() {
        $conn = $this->connect();
        $sql = "SELECT * FROM words";
        $output = ' ';
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<tr class="lineHIghlight"><th>'.$row['id_word'].'</th><th class="th1">'.$row['kana_w'].'</th><th class="th1">'.$row['roman_w'].'</th>';
            if($row['hun_w'] == $row['hun2_w']){
                $output .= '<th class="th1">'.$row['hun_w'].'</th><th class="th1">---</th></tr>';
            }
            else {
                $output .= '<th class="th1">'.$row['hun_w'].'</th><th class="th1">'.$row['hun2_w'].'</th></tr>' ;   
            }
            }
        echo $output;
    }
        
    function guestSessionEn() {
        $_SESSION["logged-in"] = false;
        $_SESSION['lang'] = 0;
        header("Location: ../en/guest.en.dashboard.php");
    }
    
    function guestSessionHu() {
        $_SESSION["logged-in"] = false;
        $_SESSION['lang'] = 1;
        header("Location: ../hu/guest.hu.dashboard.php");
    }
    
    function wordGameRandomHu() {
        $conn = $this->connect();
        $statement = rand(1,3);
        $sql = "SELECT * FROM words ORDER BY RAND() LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if($statement == 1) {
            //hiragana > magyar
            while($row = mysqli_fetch_array($result)){
                echo "<!doctype html>
                <html lang='hu'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Random szójáték</title>
                </head>
                <body>
                <div align='center'>
                    <h3>Mit jelent '".$row['kana_w']."' Magyarul?</h3>
                    <form action='../../inc/inc.hu.word.game.random.check.php' name='wordRandomGame' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Válasz' onkeyup='valid(this)' onblur='valid(this)' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Ellenőrzés'>
                        <br>
                        <input name='truth1' value='".$row['id_word']."' type='text' class='hiddenInput'>
                        <input name='methode' value='hi-hu' type='text' class='hiddenInput'>
                    </form>
                </div>
                <div align='center'>
                <form action='../../inc/inc.hu.guest.back.home.php'>
                    <input class='actionButton2' type='submit' value='Vissza az Irányítópultra!'>
                </form>
                </div>
                </body>
                </html>";
            }
        }
        else if($statement == 2){
            //hiragana > ro-maji
            while($row = mysqli_fetch_array($result)){
                echo "<!doctype html>
                <html lang='hu'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Random szójáték</title>
                </head>
                <body>
                <div align='center'>
                    <h3>Írd átt '".$row['kana_w']."'-t Ro-majira. (írd le latin betűkkel.)</h3>
                    <form action='../../inc/inc.hu.word.game.random.check.php' name='wordRandomGame' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Válasz' onkeyup='valid(this)' onblur='valid(this)' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Ellenőrzés'>
                        <br>
                        <input name='truth1' value='".$row['id_word']."' type='text' class='hiddenInput'>
                        <input name='methode' value='hi-ro' type='text' class='hiddenInput'>
                    </form>
                </div>
                <div align='center'>
                <form action='../../inc/inc.hu.guest.back.home.php'>
                    <input class='actionButton2' type='submit' value='Vissza az Irányítópultra!'>
                </form>
                </div>
                </body>
                </html>";
            }
        }
        else if($statement == 3){
            //magyar > hiragana
            while($row = mysqli_fetch_array($result)){
                echo "<!doctype html>
                <html lang='hu'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Random szójáték</title>
                </head>
                <body>
                <div align='center'>
                    <h3>Fordítsd le '".$row['hun_w']."'-t Japánra. (Hiragana-t használj!)</h3>
                    <form action='../../inc/inc.hu.word.game.random.check.php' name='wordRandomGame' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Válasz' onkeyup='valid(this)' onblur='valid(this)' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Ellenőrzés'>
                        <br>
                        <input name='truth1' value='".$row['id_word']."' type='text' class='hiddenInput'>
                        <input name='methode' value='hu-hi' type='text' class='hiddenInput'>
                    </form>
                </div>
                <div align='center'>
                <form action='../../inc/inc.hu.guest.back.home.php'>
                    <input class='actionButton2' type='submit' value='Vissza az Irányítópultra!'>
                </form>
                </div>
                </body>
                </html>";
            }  
        }
    }
    
    function wordGameCheckHu() {
        $conn = $this->connect();

        $ans = $_POST['answer'];
        $truth = $_POST['truth1'];
        $meth = $_POST['methode'];
        $trueanswer1;
        $trueanswer2;
        $beans;
        $sql = "SELECT * FROM words WHERE id_word='$truth'";
        if ($meth  == "hi-hu"){
             $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['hun_w'];
                $trueanswer2 = $row['hun2_w'];
                $beans = $row['kana_w'];
            }
                if($trueanswer1 == $ans || $trueanswer2 == $ans){
                    echo "<!doctype html>
                    <html>
                    <head>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Random szójáték</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Helyes válasz!</h2>
                        <br>
                        <h3>'".$beans."' valóban azt jelenti, hogy '".$trueanswer1."'.</h3>
                        <form action='../hu/subpages/hu.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                echo "<!doctype html>
                    <html>
                    <head>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Random szójáték</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Nem találtad el!</h2>
                        <br>
                        <h3>'".$beans."' azt jelenti, hogy '".$trueanswer1."'.</h3>
                        <form action='../hu/subpages/hu.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
            }
        }
        else if ($meth == "hi-ro"){
            $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['roman_w'];
                $trueanswer2 = $row['roman_w'];
                $beans = $row['kana_w'];
            }
                if($trueanswer1 == $ans || $trueanswer2 == $ans){
                    echo "<!doctype html>
                    <html>
                    <head>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Random szójáték</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Helyes válasz!</h2>
                        <br>
                        <h3>'".$beans."'-t valóban úgy kell írni, hogy '".$trueanswer1."'.</h3>
                        <form action='../hu/subpages/hu.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                echo "<!doctype html>
                    <html>
                    <head>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Random szójáték</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Nem találtad el!</h2>
                        <br>
                        <h3>'".$beans."'-t úgy kell írni, hogy '".$trueanswer1."'.</h3>
                        <form action='../hu/subpages/hu.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
            }
        }
        else{
            $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['kana_w'];
                $trueanswer2 = $row['kana_w'];
                $beans = $row['hun_w'];
            }
                if($trueanswer1 == $ans || $trueanswer2 == $ans){
                    echo "<!doctype html>
                    <html>
                    <head>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Random szójáték</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Helyes válasz!</h2>
                        <br>
                        <h3>'".$beans."' valóban azt jelenti, hogy '".$trueanswer1."'.</h3>
                        <form action='../hu/subpages/hu.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                echo "<!doctype html>
                    <html>
                    <head>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Random szójáték</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Nem találtad el!</h2>
                        <br>
                        <h3>'".$beans."' azt jelenti, hogy '".$trueanswer1."'.</h3>
                        <form action='../hu/subpages/hu.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
            }
        }
    
        
    }
    
    function wordGameRandomEn() {
        $conn = $this->connect();
        $statement = rand(1,3);
        $sql = "SELECT * FROM words ORDER BY RAND() LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if($statement == 1) {
            //hiragana > english
            while($row = mysqli_fetch_array($result)){
                echo "<!doctype html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Word practice</title>
                </head>
                <body>
                <div align='center'>
                    <h3>What does '".$row['kana_w']."' mean?</h3>
                    <form action='../../inc/inc.en.word.game.random.check.php' name='wordRandomGame' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Answer' onkeyup='valid(this)' onblur='valid(this)' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Check'>
                        <br>
                        <input name='truth1' value='".$row['id_word']."' type='text' class='hiddenInput'>
                        <input name='methode' value='hi-en' type='text' class='hiddenInput'>
                    </form>
                </div>
                <br>
                <div align='center'>
                <form action='../../inc/inc.en.guest.back.home.php'>
                    <input class='actionButton1' type='submit' value='Back to home!'>
                </form>
                </div>
                </body>
                </html>";
            }
        }
        else if($statement == 2){
            //hiragana > ro-maji
            while($row = mysqli_fetch_array($result)){
                echo "<!doctype html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Word practice</title>
                </head>
                <body>
                <div align='center'>
                    <h3>Write '".$row['kana_w']."' in Ro-maji (with latin letters).</h3>
                    <form action='../../inc/inc.en.word.game.random.check.php' name='wordRandomGame' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Answer' onkeyup='valid(this)' onblur='valid(this)' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Check'>
                        <br>
                        <input name='truth1' value='".$row['id_word']."' type='text' class='hiddenInput'>
                        <input name='methode' value='hi-ro' type='text' class='hiddenInput'>
                    </form>
                </div>
                <div align='center'>
                <form action='../../inc/inc.en.guest.back.home.php'>
                    <input class='actionButton1' type='submit' value='Back to home!'>
                </form>
                </div>
                </body>
                </html>";
            }
        }
        else if($statement == 3){
            //english > hiragana
            while($row = mysqli_fetch_array($result)){
                echo "<!doctype html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Word practice</title>
                </head>
                <body>
                <div align='center'>
                    <h3>Translate '".$row['eng_w']."' to Japanese. (Use Hiragana!)</h3>
                    <form action='../../inc/inc.en.word.game.random.check.php' name='wordRandomGame' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Answer' onkeyup='valid(this)' onblur='valid(this)' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Check'>
                        <br>
                        <input name='truth1' value='".$row['id_word']."' type='text' class='hiddenInput'>
                        <input name='methode' value='en-hi' type='text' class='hiddenInput'>
                    </form>
                </div>
                <div align='center'>
                <form action='../../inc/inc.en.guest.back.home.php'>
                    <input class='actionButton1' type='submit' value='Back to home!'>
                </form>
                </div>
                </body>
                </html>";
            }  
        }
    }
    
    function wordGameCheckEn() {
        $conn = $this->connect();

        $ans = $_POST['answer'];
        $truth = $_POST['truth1'];
        $meth = $_POST['methode'];
        $trueanswer1;
        $trueanswer2;
        $beans;
        $sql = "SELECT * FROM words WHERE id_word='$truth'";
        if ($meth  == "hi-en"){
             $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['eng_w'];
                $trueanswer2 = $row['eng2_w'];
                $beans = $row['kana_w'];
            }
                if($trueanswer1 == $ans || $trueanswer2 == $ans){
                    echo "<!doctype html>
                    <html>
                    <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Word practice</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Correct answer!</h2>
                        <br>
                        <h3>'".$beans."' means '".$trueanswer1."'.</h3>
                        <form action='../en/subpages/en.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                echo "<!doctype html>
                    <html>
                    <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Word practice</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Wrong answer!</h2>
                        <br>
                        <h3>'".$beans."' means '".$trueanswer1."'.</h3>
                        <form action='../en/subpages/en.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
            }
        }
        else if ($meth == "hi-ro"){
            $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['roman_w'];
                $trueanswer2 = $row['roman_w'];
                $beans = $row['kana_w'];
            }
                if($trueanswer1 == $ans || $trueanswer2 == $ans){
                    echo "<!doctype html>
                    <html>
                    <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Word practice</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Correct answer!</h2>
                        <br>
                        <h3>'".$beans."' is written as '".$trueanswer1."'</h3>
                        <form action='../en/subpages/en.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                echo "<!doctype html>
                    <html>
                    <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Word practice</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Wrong answer!</h2>
                        <br>
                        <h3>'".$beans."' is written as '".$trueanswer1."'</h3>
                        <form action='../en/subpages/en.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
            }
        }
        else{
            $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['kana_w'];
                $trueanswer2 = $row['kana_w'];
                $beans = $row['eng_w'];
            }
                if($trueanswer1 == $ans || $trueanswer2 == $ans){
                    echo "<!doctype html>
                    <html>
                    <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Word practice</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Correct answer!</h2>
                        <br>
                        <h3>'".$ans."' means '".$trueanswer1."'</h3>
                        <form action='../en/subpages/en.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                echo "<!doctype html>
                    <html>
                    <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../../scripts/back.js'></script>
                    <title>JStA Word practice</title>
                    </head>
                    <body>";
                        echo "<div align='center'>
                        <h2>Wrong answer!</h2>
                        <br>
                        <h3>'".$beans."' means '".$trueanswer1."'</h3>
                        <form action='../en/subpages/en.word.practice.random.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
            }
        }
    
        
    }
#felkesz fuggveny \/ (megoldas: session for not-logged-in users)
    function hiraganaSubPageAssembler($kanaID) {
        $conn = $this->connect();
        $output = "<!doctype html>
        <html>
        <head>
        <link rel='stylesheet' href='../../../assets/common.stylesheet.css'>
        <link rel='shortcut icon' href='../../../Project-JStA/wip/logo/index_logo.png'/>
        <script src='../../../scripts/back.js'></script>
        <title>JStA Hiragana ".$kanaID."</title>
        </head>
        <body>";
        if(isset($_SESSION["logged-in"])){
        $fetchNoteRun = true;
        $hiragana = '';
        $romaji = '';
        $note_hu = '';
        $note_en = '';
        $learn = '';
        $note_user = '';
        $rowid = '';
        $modifier = '';
        $userID = $_SESSION['userID'];
        $learn_image = "../../../assets/pic/hiragana/".$kanaID.".png";
        $stroke_image = "../../../assets/pic/hiragana/".$kanaID."stroke.png";
        $sql = "SELECT * FROM hiragana WHERE roman_hi = '".$kanaID."'";
        $output .= "<div align='center'>";
        
        
        $result = mysqli_query($conn, $sql);
            try{
        while ($row = $result->fetch_assoc()) {
            $hardID = $row['id_hi'];
            $hiragana = $row['kana_hi'];
            $romaji = $row['roman_hi'];
            $note_hu = $row['note_hi'];
            $note_en = $row['note_ehi'];
            $learn = $row['learn_hi'];
            $note_user = $row['note_uhi'];
            $rowid = $row['row_hi'];
            $modifier = $row['mod_hi'];
            $output .= "<h1>Hiragana ".$hiragana." (".$kanaID.")</h1>";

            
            if($_SESSION['lang'] == 0){
            if($modifier == "-"){
                $output .= "<img src='".$learn_image."' alt='How to remember ".$hiragana."' class='image_kana_learn'>";
                $output .= "<img src='".$stroke_image."' alt='Hiragana ".$hiragana." stroke order' class='image_kana_stroke'>";
                }
                else{
                    $output .= "<img src='".$stroke_image."' alt='Hiragana ".$hiragana." stroke order' class='image_kana_strokeAlt'>";
                }
            if($learn != " "){
            $output .= "<h3>This may help you learn this Hiragana character:</h3>";
            $output .= "<p>".$learn."</p><br>";
            }
            if($note_en != ' '){
                $output .= "<h3>Some useful information about this Hiragana character:</h3>";
                $output .= "<p>".$note_en."</p><br>";
            }
            $output .= "<h3>Your notes:</h3>";
                $sql2 = "SELECT * FROM user_notes WHERE uid = '$userID' AND note_index = '".$note_user."'";
                $result2 = mysqli_query($conn, $sql2);
                while ($row = $result2->fetch_assoc()) {
                        $user_note_text = $row['user_note'];
                        $fetchNoteRun = false;
                        $output .= "<p>".$user_note_text."</p>";
                        $output .= "<form action='../../inc.add.user.note.php' name='updateUserNote' method='post'>
                            <input class='actionButton2' type='submit' name='' value='Update note'>
                            <br>
                            <input class='hiddenInput' type'text' name='noteValue' value='".$note_user."'>
                            </form>";
                        }
                if($fetchNoteRun) {
                    $output .= "<p>It appears that you dont have any notes recorded for this character yet.<br>
                                        To add a note, please click on the button below.</p>
                                    <form action='inc.add.user.note.php' name='addUserNote' method='post'>
                                    <input class='actionButton1' type='submit' name='' value='Add note'><br>
                                    <input class='hiddenInput' type'text' name='noteValue' value='".$note_user."'>
                                    </form>";
                }
                $output .= "<h3>Other parameters of this syllable:</h3>";
                $output .= "<p>Part of the ";
                if($rowid != "-"){
                    $output .= $rowid;
                }
                else{
                    $output .= "base";
                }
                $output .= " row in the Hiragana table.</p>";
                if($modifier != "-"){
                $output .= "<p>It is a modified version of a base character in the ".$modifier." row.</p>";
                }
                $output .= "<div align='center'>
                    <form action='../../../en/subpages/en.hiragana.table.php'>
                        <input class='actionButton1' type='submit' name='' value='Back'><br>
                    </form>
                </div>";
                $output .= "</div>
                </body>
            </html>";
        }
        else {
            $output .= "<img src='".$stroke_image."' alt='Hiragana ".$hiragana." rajzolási sorrend' class='image_kana_strokeAlt'>";
            
            if($note_en != ' '){
                $output .= "<h3>Néhány hasznos információ erről a karakterről:</h3>";
                $output .= "<p>".$note_hu."</p><br>";
            }
            $output .= "<h3>Saját jegyzetek:</h3>";
                $sql2 = "SELECT * FROM user_notes WHERE uid = '$userID' AND note_index = '".$note_user."'";
                $result2 = mysqli_query($conn, $sql2);
                while ($row = $result2->fetch_assoc()) {
                        $user_note_text = $row['user_note'];
                        $fetchNoteRun = false;
                        $output .= "<p>".$user_note_text."</p>";
                        $output .= "<form action='../../inc.add.user.note.php' name='updateUserNote' method='post'>
                            <input class='actionButton2' type='submit' name='' value='Jegyzet frissítése'>
                            <br>
                            <input class='hiddenInput' type'text' name='noteValue' value='".$note_user."'>
                            </form>";
                        }
                if($fetchNoteRun) {
                    $output .= "<p>Úgy látszik, még nem hoztál létre jegyzetet ehhez a karakterhez.<br>
                                        Jegyzet létrehozásához kattints a <i>Jegyzet hozzáadása</i> gombra.</p>
                                    <form action='../../inc.add.user.note.php' name='addUserNote' method='post'>
                                    <input class='actionButton2' type='submit' name='' value='Jegyzet hozzáadása'><br>
                                    <input class='hiddenInput' type'text' name='noteValue' value='".$note_user."'>
                                    </form>";
                }
                $output .= "<h3>Egyéb adatai ennek a karakternek:</h3>";
                $output .= "<p>A(z) ";
                if($rowid != "-"){
                    $output .= $rowid;
                }
                else{
                    $output .= "alap";
                }
                $output .= " sor része a Hiragana táblában.</p>";
                if($modifier != "-"){
                $output .= "<p>Egy '".$modifier."' sorba tartozó karakter módosított változata.</p>";
                }
            $output .= "<div align='center'>
            <form action='../../../hu/subpages/hu.hiragana.table.php'>
            <input class='actionButton1' type='submit' name='' value='Vissza'><br>
            </form>
            </div>";
            $output .= "</div>
                </body>
            </html>";
            
        }
        }
            }
            catch (Exception $e) {
                echo "Something went wrong!<br>
                If the problem persists, please submit a bug ticket on discord ( ) in the 'bugreport' chatroom <br> 
                where you describe what were you trying to do in as much detail as possible (for example: location, internet connection and other information you may find useful).<br>
                Please make sure to include the following error code AS IS!:<br>";
                echo $e;
            }
            
        
        }
        else {
            $output .= "<div align='center'>
            <h2>You are not logged in!</h2><br>
                            <h3>To access this feature, you have to be logged in!</h3>
                            <form action='../../../inc/inc.login.php' name='loginRedirect' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Log In'>
                            </form>
                                    
                            <form action='../../../inc/inc.signup.php' name='registerRedirect' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Register'>
                            </form>
                            </div>
                </body>
            </html>";
        }
        echo $output;
        
    }
    
    function readUserNote($noteWhere) {
        $conn = $this->connect();
        $output = '';
        $fetchNoteRun = false;
        $userID = $_SESSION['userID'];
        $user_note_text = ' ';
        if($_SESSION['lang'] == 0){
            $userNote;
            $sql = "SELECT * FROM hiragana WHERE note_uhi = '".$noteWhere."'";
            $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $kana = $row['kana_hi'];
                $romaji = $row['roman_hi'];
                $output .= "<!doctype html>
                <html>
                <head>
                <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                <script src='../scripts/back.js'></script>
                <title>JStA Note creation ".$kana."</title>
                </head>
                <body>
                <div align='center'>";
                $sql2 = "SELECT * FROM user_notes WHERE uid = '$userID' AND note_index = '".$noteWhere."'";
                    $result2 = mysqli_query($conn, $sql2);
                    while ($row = $result2->fetch_assoc()) {
                        $user_note_text = $row['user_note'];
                        $fetchNoteRun = true;
                    }
                if($fetchNoteRun)
                {
                    $output .= "<form action='inc.submit.user.note.php' name='noteSubmit' method='post'>
                                <textarea name='noteText' autofocus class='noteField1' type='text' value='' maxlength='65000' cols='200' rows='10'>".$user_note_text."</textarea>
                                <br>
                                <input class='actionButton1' type='submit' name='' value='Save note'>
                                <br>
                                <input class='hiddenInput' type='text' name='noteID' value='".$noteWhere."'>
                                <input class='hiddenInput' type='text' name='wasThere' value='".$romaji."'>
                                <input class='hiddenInput' type='text' name='isThere' value='true'>
                                </form>";
                }
                else {
                    $output .= "<form action='inc.submit.user.note.php' name='noteSubmit' method='post'>
                                <input autofocus class='noteField1' type='text' value='' name='note' maxlength='65000' placeholder='Write your note...'>
                                <br>
                                <input class='actionButton1' type='submit' name='' value='Save note'>
                                <br>
                                <input class='hiddenInput' type='text' name='noteID' value='".$noteWhere."'>
                                <input class='hiddenInput' type='text' name='wasThere' value='".$romaji."'>
                                <input class='hiddenInput' type='text' name='isThere' value='false'>
                                </form>";
                }
                $output .= "</div>
                            </body>
                            </html>";
                }
            }
        else {
            $userNote;
            $sql = "SELECT * FROM hiragana WHERE note_uhi = '".$noteWhere."'";
            $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $kana = $row['kana_hi'];
                $romaji = $row['roman_hi'];
                $output .= "<!doctype html>
                <html>
                <head>
                <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                <script src='../scripts/back.js'></script>
                <title>JStA Jegyzet készítés ".$kana."</title>
                </head>
                <body>
                <div align='center'>";
                $sql2 = "SELECT * FROM user_notes WHERE uid = '$userID' AND note_index = '".$noteWhere."'";
                    $result2 = mysqli_query($conn, $sql2);
                    while ($row = $result2->fetch_assoc()) {
                        $user_note_text = $row['user_note'];
                        $fetchNoteRun = true;
                    }
                if($fetchNoteRun)
                {
                    $output .= "<form action='inc.submit.user.note.php' name='noteSubmit' method='post'>
                                <textarea name='noteText' autofocus class='noteField1' type='text' value='' maxlength='65000' cols='200' rows='10'>".$user_note_text."</textarea>
                                <br>
                                <input class='actionButton2' type='submit' name='' value='Jegyzet mentése'>
                                <br>
                                <input class='hiddenInput' type='text' name='noteID' value='".$noteWhere."'>
                                <input class='hiddenInput' type='text' name='wasThere' value='".$romaji."'>
                                <input class='hiddenInput' type='text' name='isThere' value='true'>
                                </form>";
                }
                else {
                    $output .= "<form action='inc.submit.user.note.php' name='noteSubmit' method='post'>
                                <textarea name='noteText' autofocus class='noteField1' type='text' value='' maxlength='65000' cols='200' rows='10'placeholder='Jegyzet írása...'></textarea>
                                <br>
                                <input class='actionButton2' type='submit' name='' value='Jegyzet mentése'>
                                <br>
                                <input class='hiddenInput' type='text' name='noteID' value='".$noteWhere."'>
                                <input class='hiddenInput' type='text' name='wasThere' value='".$romaji."'>
                                <input class='hiddenInput' type='text' name='isThere' value='false'>
                                </form>";
                }
                $output .= "</div>
                            </body>
                            </html>";
                }
        }
        echo $output;
        
    }
    
    function writeUserNote($noteWhere, $noteText, $wasThere, $isThere) {
        $conn = $this->connect();
        $noteTextLocal = mysqli_real_escape_string($conn, $noteText);
		$langL = $_SESSION['lang'];
        $userID = $_SESSION['userID'];
        /*echo $noteTextLocal;*/
        /*echo " userID ".$userID;
        echo " note_index ".$noteWhere;
        echo " note ".$noteText."<br>";*/
        $sqlCheckNoteExists = "SELECT * FROM user_notes WHERE uid='".$userID."' AND note_index = '".$noteWhere."'";
		$result = $conn->query($sqlCheckNoteExists);
        if(mysqli_num_rows($result) > 0){
            $sqlUpdate = "UPDATE `user_notes` SET `uid`='".$userID."',`note_index`='".$noteWhere."',`user_note`='".$noteTextLocal."' WHERE uid='".$userID."' AND note_index = '".$noteWhere."'";
            /*echo $sqlUpdate;*/
            $conn->query($sqlUpdate);
            /*echo "<br>updated";*/
		}
        else {
            $sqlInsert = "INSERT INTO `user_notes`(`id`, `uid`, `note_index`, `user_note`) VALUES (null , '".$userID."', '".$noteWhere."','".$noteTextLocal."')";
            /*echo $sqlInsert;*/
            $conn->query($sqlInsert);
            /*echo "<br>inserted";*/
        }
        
        header("Location: kana/hiragana/inc.kana.hiragana.redirect.".$wasThere.".php");
    }
}