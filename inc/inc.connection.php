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
    
    function kanjiBasicsAssembler(){
        if ($_SESSION['lang'] == 0){
            $output = "<!doctype html>
                    <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <title>JStA Kanji list</title>
                        </head>
                        <div align='center'>
                        <h1>This page is under construction!</h1>
                        <form action='../en/subpages/en.kanji.tools.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Back'>
                        </form>";
            echo $output;
        }
        else{
            $output = "<!doctype html>
                    <html lang='hu'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <title>JStA Kanji lista</title>
                        </head>
                    <div align='center'>
                    <h1>Ez az oldal jelenleg nem elérhető!</h1>
                        <form action='../hu/subpages/hu.kanji.tools.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Vissza'>
                        </form>";
            echo $output;
        }
    }
    
    function kanjiListFill(){
        $conn = $this->connect();
        $sql = "SELECT * FROM kanji";
        $result = mysqli_query($conn, $sql);
        
        if ($_SESSION['lang'] == 0){
        $output = "<!doctype html>
                    <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <title>JStA Kanji list</title>
                        </head>
                    <div align='center'>
                        <form action='../en/subpages/en.kanji.tools.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Back'>
                        </form>
                        <br>
                        <table class='tableKanji'>
                        <caption><h1>Kanji list</h1></caption>";
            $output .= "<tr>
                            <th><h2>Kajni</h2></th>
                            <th><h2>Meaning</h2></th>
                            <th><h2>Readings</h2></th> 
                            <th><h2>Parameters</h2></th>
                            <th><h2>Commons uses</h2></th>
                        </tr>";
            while($row = $result->fetch_assoc()){
                $kanjiID = $row['id'];
                $kanji = $row['kanji'];
                $engMeaning = $row['eng'];
                $hunMeaning = $row['hun'];
                $userNoteID = $row['note_ukan'];
                $readingON = $row['read_on'];
                $readingON2 = $row['read_on2'];
                $romanizedON = $row['on_romanized_1'];
                $romanizedON2 = $row['on_romanized_2'];
                $readingKUN = $row['read_kun'];
                $readingKUN2 = $row['read_kun2'];
                $romanizedKUN = $row['kun_romanized_1'];
                $romanizedKUN2 = $row['kun_romanized_2'];
                $radical = $row['radical'];
                $strokeNumber = $row['stroke_number'];
                $engComm = $row['comm_en'];
                
                $readings = "";
                if($readingON2 != " "){
                    $readings .= "ON reading:<br>$readingON ($romanizedON), $readingON2 ($romanizedON2)<br>";
                }
                else{
                    $readings .= "ON reading:<br>$readingON ($romanizedON)<br>";
                }
                if($readingKUN2 != " "){
                    $readings .= "KUN reading:<br>$readingKUN ($romanizedKUN), $readingKUN2 ($romanizedKUN2)";
                }
                else{
                    $readings .= "KUN reading:<br>$readingKUN ($romanizedKUN)";
                }
                
                $output .= "<tr class='hover'>
                                <th class='kanjiCell'>$kanji</th>
                                <th class='cellMiddleNoAlign'>$engMeaning</th>
                                <th class='cellMiddle'>$readings</th>
                                <th class='cellMiddle'>Radical: $radical<br>Strokes: $strokeNumber<br>Unique ID:$kanjiID</th>
                                <th class='cellEnd'>$engComm</th>
                            </tr>";   
        }
            echo $output;
        }
        else {
            $output = "<!doctype html>
                    <html lang='hu'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <title>JStA Kanji lista</title>
                        </head>
                    <div align='center'>
                        <form action='../hu/subpages/hu.kanji.tools.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Vissza'>
                        </form>
                        <br>
                        <table class='tableKanji'>
                        <caption><h1>Kanji lista</h1></caption>";
            $output .= "<tr>
                            <th><h2>Kajni</h2></th>
                            <th><h2>Jelentés</h2></th>
                            <th><h2>Kiolvasás</h2></th> 
                            <th><h2>Adatok</h2></th>
                            <th><h2>Gyakori használatok</h2></th>
                        </tr>";
            while($row = $result->fetch_assoc()){
                $kanjiID = $row['id'];
                $kanji = $row['kanji'];
                $engMeaning = $row['eng'];
                $hunMeaning = $row['hun'];
                $userNoteID = $row['note_ukan'];
                $readingON = $row['read_on'];
                $readingON2 = $row['read_on2'];
                $romanizedON = $row['on_romanized_1'];
                $romanizedON2 = $row['on_romanized_2'];
                $readingKUN = $row['read_kun'];
                $readingKUN2 = $row['read_kun2'];
                $romanizedKUN = $row['kun_romanized_1'];
                $romanizedKUN2 = $row['kun_romanized_2'];
                $radical = $row['radical'];
                $strokeNumber = $row['stroke_number'];
                $hunComm = $row['comm_hu'];
                
                $readings = "";
                if($readingON2 != " "){
                    $readings .= "ON kiolvasás:<br>$readingON ($romanizedON), $readingON2 ($romanizedON2)<br>";
                }
                else{
                    $readings .= "ON kiolvasás:<br>$readingON ($romanizedON)<br>";
                }
                if($readingKUN2 != " "){
                    $readings .= "KUN kiolvasás:<br>$readingKUN ($romanizedKUN), $readingKUN2 ($romanizedKUN2)";
                }
                else{
                    $readings .= "KUN kiolvasás:<br>$readingKUN ($romanizedKUN)";
                }
                
                $output .= "<tr class='hover'>
                                <th class='kanjiCell'>$kanji</th>
                                <th class='cellMiddleNoAlign'>$hunMeaning</th>
                                <th class='cellMiddle'>$readings</th>
                                <th class='cellMiddle'>Radikális: $radical<br>Vonások: $strokeNumber<br>Egyedi azonosító:$kanjiID</th>
                                <th class='cellEnd'>$hunComm</th>
                            </tr>";   
        }
            echo $output;
        }
    }
   #no hungarian support yet \/ solved?
    function yourDictionaryPageAssembler(){
        $conn = $this->connect();
        $sql1 = "SELECT * FROM userdictionaryconnect WHERE userid = '".$_SESSION['userID']."'";
        $result1 = $conn->query($sql1);
        $tableName = "";
        if ($_SESSION['lang'] == 0){
            $output = "<!doctype html>
                    <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <title>JStA Your dictionary</title>
                        </head> 
                        <div align='center'>";
            if(mysqli_num_rows($result1) > 0){
                $result2 = mysqli_query($conn, $sql1);
                while ($row = $result2->fetch_assoc()){
                    $tableName = $row['tableName'];
                    $output .= "<h3>You can list the words in your dictionary here:</h3>
                    <form action='inc.list.user.dictionary.php' name='listUserDic' method='post'>
                            <input class='actionButton1' type='submit' name='' value='".$tableName."'>
                    </form>
                    <h3>Or you can play <i>Do you know the word?</i> with the words in your dictionary:</h3>
                    <form action='inc.word.game.user.dictionary.php' name='randomWordGameUserDic' method='post'>
                            <input class='actionButton3' type='submit' name='' value='Do you know the word?'>
                    </form>
                    <br>
                    <form action='../en/subpages/en.word.practice.tool.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Back'>
                    </form>";
                }
            }
            else{
                $output .= "<h1>You currently have no personal dictionary!</h1>
                <h3>Would you like to create one now?</h3>
                <div align='center'>
                        <form action='inc.create.user.dictionary.php' name='createUserDictionary' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Yes'>
                </form>
                <form action='../en/subpages/en.word.practice.tool.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='No'>
                </form>";
            }
            echo $output;
        }
        else{
            $output = "<!doctype html>
                    <html lang='hu'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <title>JStA A te szótárad</title>
                        </head> 
                        <div align='center'>";
            if(mysqli_num_rows($result1) > 0){
                $result2 = mysqli_query($conn, $sql1);
                while ($row = $result2->fetch_assoc()){
                    $tableName = $row['tableName'];
                    $output .= "<h3>Itt listázhatod a szótáradban lévő szavakat:</h3>
                    <form action='inc.list.user.dictionary.php' name='listUserDic' method='post'>
                            <input class='actionButton1' type='submit' name='' value='".$tableName."'>
                    </form>
                    <h3>Vagy játszhatsz a<i>Tudod a szót?</i> játékot a szótáradban szereplő szavakal:</h3>
                    <form action='inc.word.game.user.dictionary.php' name='randomWordGameUserDic' method='post'>
                            <input class='actionButton3' type='submit' name='' value='Tudod a szót?'>
                    </form>
                    <br>
                    <form action='../hu/subpages/hu.word.practice.tool.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Vissza'>
                    </form>";
                }
            }
            else{
                $output .= "<h1>Jelenleg nem rendelkezel saját szótárral!</h1>
                <h3>Szeretnél most létrehozni egyet?</h3>
                <div align='center'>
                        <form action='inc.create.user.dictionary.php' name='createUserDictionary' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Igen'>
                </form>
                <form action='../en/subpages/en.word.practice.tool.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Nem'>
                </form>";
        }
            echo $output;
    }
    }
       #no hungarian support yet \/ solved?
    function yourDictionaryCreate(){
        $conn = $this->connect();
        $sql1 = "SELECT * FROM userdictionaryconnect WHERE userid = '".$_SESSION['userID']."'";
        $result1 = $conn->query($sql1);
        $tableName = "";
        if ($_SESSION['lang'] == 0){
            $output = "<!doctype html>
                    <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <script src='../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                            <script src='../scripts/inc.js'></script>
                            <title>JStA Kanji list</title>
                        </head> 
                        <div align='center'>";
                    $output .= "<h3>Name your dictionary:</h3>
                    <form action='inc.submit.user.dictionary.php' name='createUserDic' method='post'>
                            <input name='dicName' type='text' id='input1' placeholder='Name your dictionary' onkeyup='valid(this)' onblur='valid(this)' maxlength='14'>
                            <br>
                            <input class='actionButton1' type='submit' name='' value='Create'>
                    </form>
                    <br>
                    <form action='../en/subpages/en.word.practice.tool.php' name='cancelUserDic' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Cancel'>
                    </form>";
            echo $output;
        }
        else{
            $output = "<!doctype html>
                    <html lang='hu'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <script src='../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                            <script src='../scripts/inc.js'></script>
                            <title>JStA Kanji lista</title>
                        </head>
                        
                    <div align='center'>
                    <h3>Name your dictionary:</h3>
                    <form action='inc.submit.user.dictionary.php' name='createUserDic' method='post'>
                            <input name='dicName' type='text' id='input1' placeholder='Nevezd el a szótáradat' onkeyup='valid(this)' onblur='valid(this)' maxlength='14'>
                            <br>
                            <input class='actionButton1' type='submit' name='' value='Létrehozás'>
                    </form>
                    <br>
                    <form action='../hu/subpages/hu.word.practice.tool.php' name='createUserDic' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Mégsem'>
                    </form>";
            echo $output;
    }
    }
    
    function yourDictionarySubmit($nameOfTable){
        $conn = $this->connect();
        /*$sql1 = "SELECT * FROM userdictionaryconnect WHERE userid = '".$_SESSION['userID']."'";*/
        $tableNameLocal = mysqli_real_escape_string($conn, $nameOfTable);
        $sql1 = "INSERT INTO userdictionaryconnect (id, userid, tableName, tableRealName) VALUES (null, '".$_SESSION['userID']."', '".$tableNameLocal."', '".$_SESSION['userID']."".$tableNameLocal."')";
        $conn->query($sql1);
        $sql2 = "CREATE TABLE ".$_SESSION['userID']."".$tableNameLocal."(wordid INT NOT NULL AUTO_INCREMENT, kana VARCHAR(100) NOT NULL, romanized VARCHAR(100) NOT NULL, meaning1 VARCHAR(100) NOT NULL, meaning2 VARCHAR(100) NOT NULL, PRIMARY KEY (wordid));";
        $conn->query($sql2);
        header ("Location: inc.user.dictionary.php");
        /*$result1 = $conn->query($sql1);*/
        
    }
       #no hungarian support yet \/ solver?
    function yourDictionaryList(){
        $conn = $this->connect();
        $sql = "SELECT * FROM words";
        $output = "";
        $pageName = "";
        $pageRealName = "";
        $thereAre = false;
        $sql1 = "SELECT * FROM userdictionaryconnect WHERE userid = '".$_SESSION['userID']."'";
                $result1 = mysqli_query($conn, $sql1);
                while ($row = $result1->fetch_assoc()){
                    $pageName = $row['tableName'];
                    $pageRNTemp = $row['tableRealName'];
                    $pageRealName = mysqli_real_escape_string($conn, $pageRNTemp);
                }
        $sql2 = "SELECT * FROM ".$pageRealName."";
        $result = $conn->query($sql2);
        if(mysqli_num_rows($result) > 0){
            $thereAre = true;
        }
        if($_SESSION['lang'] == 0){
        $output .= "<!doctype html>
                    <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <script src='../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                            <script src='../scripts/inc.js'></script>
                            <title>JStA ".$pageName."</title>
                        </head> 
                        <div align='center'>
                        <form action='inc.user.dictionary.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Back'>
                    </form><br>";
            $output .=  "<table style='width:85%''>
            <caption><h2>Your ".$pageName." dictionary</h2></caption>
                    <tr>
                    <th><h2>ID</h2></th>
                    <th><h2>Kana</h2></th> 
                    <th><h2>Ro-maji</h2></th>
                    <th><h2>Meaning 1</h2></th>
                    <th><h2>Meaning 2</h2></th>
                    <th>This action is immediate<br>and irriversable!</th>
                </tr>";
        if($thereAre){
            $result = mysqli_query($conn, $sql2);
            while ($row = mysqli_fetch_array($result)) {
                $output .= '<tr class="lineHIghlight"><th>'.$row['wordid'].'</th><th class="th1">'.$row['kana'].'</th><th class="th1">'.$row['romanized'].'</th>';
                $output .= '<th class="th1">'.$row['meaning1'].'</th><th class="th1">'.$row['meaning2'].'</th>';
                $output .= "<th><form action='inc.delete.word.user.dictionary.php' name='addWordUserDic' method='post'>
                <input class='actionButton1' type='submit' name='' value='Delete'>
                <input class='hiddenInput' name='wordid' type='number' id='id1' value='".$row['wordid']."'>
                </form>
                </th>";
                
            }
        }
        else{
            $output .= "Your dictionary is currently empty...<br>";
            
        }
            $output .= "<tr><form action='inc.add.word.user.dictionary.php' name='addWordUserDic' method='post'>
                            <th><input class='actionButton1' type='submit' name='' value='Add'></th>
                            <th><input name='kana' type='text' id='input2' placeholder='れい (例)' maxlength='20'></th>
                            <th><input name='romanized' type='text' id='input3' placeholder='rei' maxlength='50'></th>
                            <th><input name='meaning1' type='text' id='input4' placeholder='Example' maxlength='50'></th>
                            <th><input name='meaning2' type='text' id='input5' placeholder='Example' maxlength='50'></th>
                            <th></th>
                    </form></tr>";
            echo $output;
        }
        else{
            $output .= "<!doctype html>
                    <html lang='hu'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                            <link rel='stylesheet' href='../assets/kanji_table_format.css'>
                            <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                            <script src='../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                            <script src='../scripts/inc.js'></script>
                            <title>JStA ".$pageName."</title>
                        </head> 
                        <div align='center'>
                        <form action='inc.user.dictionary.php' name='back' method='post'>
                            <input class='actionButton1' type='submit' name='' value='Vissza'>
                    </form><br>";
            $output .=  "<table style='width:85%''>
            <caption><h2>A te ".$pageName." szótárad</h2></caption>
                    <tr>
                    <th><h2>ID</h2></th>
                    <th><h2>Kana</h2></th> 
                    <th><h2>Ro-maji</h2></th>
                    <th><h2>Jelentés 1</h2></th>
                    <th><h2>Jelentés 2</h2></th>
                    <th>Ez a művelet azonnali,<br>és visszafordíthatatlan!</th>
                </tr>";
        if($thereAre){
            $result = mysqli_query($conn, $sql2);
            while ($row = mysqli_fetch_array($result)) {
                $output .= '<tr class="lineHIghlight"><th>'.$row['wordid'].'</th><th class="th1">'.$row['kana'].'</th><th class="th1">'.$row['romanized'].'</th>';
                $output .= '<th class="th1">'.$row['meaning1'].'</th><th class="th1">'.$row['meaning2'].'</th>';
                $output .= "<th><form action='inc.delete.word.user.dictionary.php' name='addWordUserDic' method='post'>
                <input class='actionButton1' type='submit' name='' value='Törlés'>
                <input class='hiddenInput' name='wordid' type='number' id='id1' value='".$row['wordid']."'>
                </form>
                </th>";
                
            }
        }
        else{
            $output .= "A szótár jelenleg üres...<br>";
            
        }
            $output .= "<tr><form action='inc.add.word.user.dictionary.php' name='addWordUserDic' method='post'>
                            <th><input class='actionButton1' type='submit' name='' value='Hozzáad'></th>
                            <th><input name='kana' type='text' id='input2' placeholder='れい (例)' maxlength='20'></th>
                            <th><input name='romanized' type='text' id='input3' placeholder='rei' maxlength='50'></th>
                            <th><input name='meaning1' type='text' id='input4' placeholder='Példa' maxlength='50'></th>
                            <th><input name='meaning2' type='text' id='input5' placeholder='Példa' maxlength='50'></th>
                            <th></th>
                    </form></tr>";
            echo $output;
        }
    }
    
    function yourDictionaryAddWord($kana, $romanized, $meaning1, $meaning2){
        $conn = $this->connect();
        $kanaLocal = mysqli_real_escape_string($conn, $kana);
        $romanizedLocal = mysqli_real_escape_string($conn, $romanized);
        $meaning1Local = mysqli_real_escape_string($conn, $meaning1);
        $meaning2Local = mysqli_real_escape_string($conn, $meaning2);
        $tableName;
        $sql2 = "SELECT * FROM userdictionaryconnect WHERE userid = '".$_SESSION['userID']."'";
        $result2 = mysqli_query($conn, $sql2);
                while ($row = $result2->fetch_assoc()){
                    $tableName = $row['tableRealName'];
                }
        $tableNameLocal = mysqli_real_escape_string($conn, $tableName);
        $sql1 = "INSERT INTO `".$tableNameLocal."`(wordid, kana, romanized, meaning1, meaning2) VALUES (null, '".$kanaLocal."','".$romanizedLocal."', '".$meaning1Local."', '".$meaning2Local."')";
        $conn->query($sql1);
        header("Location: inc.list.user.dictionary.php");
    }
    
    function yourDictionaryDeleteWord($where){
        $conn = $this->connect();
        $tableName;
        $sql1 = "SELECT * FROM userdictionaryconnect WHERE userid = '".$_SESSION['userID']."'";
        $result1 = mysqli_query($conn, $sql1);
                while ($row = $result1->fetch_assoc()){
                    $tableName = $row['tableRealName'];
                }
        $sql2 = "DELETE FROM ".$tableName." WHERE wordid = '$where'";
        $conn->query($sql2);
        header("Location: inc.list.user.dictionary.php");
    }
    #kana > language (ka-lng), kana > romanized (ka-rm), language > kana (lng-ka)
    function yourDictionaryWordGameRandom(){
        $conn = $this->connect();
        $op = "";
        $statement = rand(1,3);
        $tableName;
        $titleEx;
        $sql2 = "SELECT * FROM userdictionaryconnect WHERE userid = '".$_SESSION['userID']."'";
        $result2 = mysqli_query($conn, $sql2);
                while ($row = $result2->fetch_assoc()){
                    $tableName = $row['tableRealName'];
                    $titleEx = $row['tableName'];
                }
        $tableNameLocal = mysqli_real_escape_string($conn, $tableName);
        $sql = "SELECT * FROM ".$tableNameLocal." ORDER BY RAND() LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if($_SESSION['lang'] == 0){
            $op .= "<!doctype html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../scripts/back.js'></script>
                    <title>JStA ".$titleEx." Do you know the word?</title>
                </head>
                <body>
                <div align='center'>";
        if($statement == 1) {
            //kana > lang
            while($row = mysqli_fetch_array($result)){
                $op .= "
                    <h3>What does '".$row['kana']."' mean?</h3>
                    <form action='inc.word.game.user.dictionary.check.php' name='wordCheck' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Answer' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Check'>
                        <br>
                        <input name='truth1' value='".$row['wordid']."' type='text' class='hiddenInput'>
                        <input name='methode' value='ka-lng' type='text' class='hiddenInput'>
                    </form>
                </div>
                <br>
                <div align='center'>
                <form action='inc.user.dictionary.php'>
                    <input class='actionButton1' type='submit' value='Finish game!'>
                </form>
                </div>
                </body>
                </html>";
            }
        }
        else if($statement == 2){
            //kana > ro-maji
            while($row = mysqli_fetch_array($result)){
                $op .= "
                    <h3>Write '".$row['kana']."' in Ro-maji (with latin letters).</h3>
                    <form action='inc.word.game.user.dictionary.check.php' name='wordCheck' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Answer' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Check'>
                        <br>
                        <input name='truth1' value='".$row['wordid']."' type='text' class='hiddenInput'>
                        <input name='methode' value='ka-rm' type='text' class='hiddenInput'>
                    </form>
                </div>
                <div align='center'>
                <form action='inc.user.dictionary.php'>
                    <input class='actionButton1' type='submit' value='Finish game!'>
                </form>
                </div>
                </body>
                </html>";
            }
        }
        else{
            //lang > kana
            while($row = mysqli_fetch_array($result)){
                $op .= "
                    <h3>Translate '".$row['meaning1']."' to Japanese.<br>(Use the kana you have defined in your dictionary)</h3>
                    <form action='inc.word.game.user.dictionary.check.php' name='wordCheck' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Answer' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Check'>
                        <br>
                        <input name='truth1' value='".$row['wordid']."' type='text' class='hiddenInput'>
                        <input name='methode' value='lng-ka' type='text' class='hiddenInput'>
                    </form>
                </div>
                <div align='center'>
                <form action='inc.user.dictionary.php'>
                    <input class='actionButton1' type='submit' value='Finish game!'>
                </form>
                </div>
                </body>
                </html>";
            }  
        }
        }
        else{
            $op .= "<!doctype html>
                <html lang='hu'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <script src='../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../scripts/back.js'></script>
                    <title>JStA ".$titleEx." Tudod a szót?</title>
                </head>
                <body>
                <div align='center'>";
        if($statement == 1) {
            //kana > lang
            while($row = mysqli_fetch_array($result)){
                $op .= "
                    <h3>Mit jelent '".$row['kana']."'?</h3>
                    <form action='inc.word.game.user.dictionary.check.php' name='wordCheck' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Válasz' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Ellenőrzés!'>
                        <br>
                        <input name='truth1' value='".$row['wordid']."' type='text' class='hiddenInput'>
                        <input name='methode' value='ka-lng' type='text' class='hiddenInput'>
                    </form>
                </div>
                <br>
                <div align='center'>
                <form action='inc.user.dictionary.php'>
                    <input class='actionButton1' type='submit' value='Játék befejezése!'>
                </form>
                </div>
                </body>
                </html>";
            }
        }
        else if($statement == 2){
            //kana > ro-maji
            while($row = mysqli_fetch_array($result)){
                $op .= "
                    <h3>Írd le '".$row['kana']."'-t Ro-majival (latin betűkkel).</h3>
                    <form action='inc.word.game.user.dictionary.check.php' name='wordCheck' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Válasz' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Ellenőrzés!'>
                        <br>
                        <input name='truth1' value='".$row['wordid']."' type='text' class='hiddenInput'>
                        <input name='methode' value='ka-rm' type='text' class='hiddenInput'>
                    </form>
                </div>
                <div align='center'>
                <form action='inc.user.dictionary.php'>
                    <input class='actionButton1' type='submit' value='Játék befejezése!'>
                </form>
                </div>
                </body>
                </html>";
            }
        }
        else{
            //lang > kana
            while($row = mysqli_fetch_array($result)){
                $op .= "
                    <h3>Fordítsd le '".$row['meaning1']."'-t Japánra.<br>(Használd a kanát, amit a szótárban megadtál!)</h3>
                    <form action='inc.word.game.user.dictionary.check.php' name='wordCheck' method='post'>
                        <input name='answer' type='text' id='input1' placeholder='Válasz' maxlength='200'>
                        <br>
                        <input class='actionButton2' type='submit' name='' value='Ellenőrzés!'>
                        <br>
                        <input name='truth1' value='".$row['wordid']."' type='text' class='hiddenInput'>
                        <input name='methode' value='lng-ka' type='text' class='hiddenInput'>
                    </form>
                </div>
                <div align='center'>
                <form action='inc.user.dictionary.php'>
                    <input class='actionButton1' type='submit' value='Játék befejezése!'>
                </form>
                </div>
                </body>
                </html>";
            }  
        }
        }
        echo $op;
    }
    
    function yourDictionaryWordGameCheck($where, $ans, $meth){
        $conn = $this->connect();
        $trueanswer1;
        $trueanswer2;
        $beans;
        $tableName;
        $titleEx;
        $output = "";
        $sql2 = "SELECT * FROM userdictionaryconnect WHERE userid = '".$_SESSION['userID']."'";
        $result2 = mysqli_query($conn, $sql2);
                while ($row = $result2->fetch_assoc()){
                    $tableName = $row['tableRealName'];
                    $titleEx = $row['tableName'];
                }
        $sql = "SELECT * FROM ".$tableName." WHERE wordid='$where'";
        $result = mysqli_query($conn, $sql);
        
        
        if($_SESSION['lang'] == 0){ #english
            $output .= "<!doctype html>
                    <html lang='en'>
                    <head>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../scripts/back.js'></script>
                    <title>JStA ".$titleEx." Do you know the word?</title>
                    </head>
                    <body>
                    <div align='center'>";
        if ($meth  == "ka-lng"){
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['meaning1'];
                $trueanswer2 = $row['meaning2'];
                $beans = $row['kana'];
            }
                if($trueanswer1 == $ans || $trueanswer2 == $ans){
                    
                    $output .= "<h2>Correct answer!</h2>
                        <br>
                        <h3>'".$beans."' means '".$trueanswer1."'.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                $output .= "
                        <h2>Wrong answer!</h2>
                        <br>
                        <h3>'".$beans."' means '".$trueanswer1."'.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
            }
        }
        else if ($meth == "ka-rm"){
            $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['romanized'];
                /*$trueanswer2 = $row['roman_w'];*/
                $beans = $row['kana'];
            }
                if($trueanswer1 == $ans){
                    $output .= "
                        <h2>Correct answer!</h2>
                        <br>
                        <h3>'".$beans."' is written as '".$trueanswer1."' in ro-maji.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                $output .= "
                        <h2>Wrong answer!</h2>
                        <br>
                        <h3>'".$beans."' is written as '".$trueanswer1."' in ro-maji.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
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
                $trueanswer1 = $row['kana'];
                $trueanswer2 = $row['romanized'];
                $beans = $row['meaning1'];
            }
                if($trueanswer1 == $ans){
                    $output .= "
                        <h2>Correct answer!</h2>
                        <br>
                        <h3>'".$beans."' means '".$trueanswer1."'.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                $output .= "<
                        <h2>Wrong answer!</h2>
                        <br>
                        <h3>'".$beans."' means '".$trueanswer1."' (".$trueanswer2.").</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Next!'>
                        </form>
                        </div>
                        </body>
                        </html>";
            }
        }
        }
        else{
            $output .= "<!doctype html>
                    <html lang='hu'>
                    <head>
                    <link rel='stylesheet' href='../assets/common.stylesheet.css'>
                    <link rel='shortcut icon' href='../Project-JStA/wip/logo/index_logo.png'/>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='../scripts/jQueryAssets/SpryDOMUtils.js'></script>
                    <script src='../scripts/back.js'></script>
                    <title>JStA ".$titleEx." Tudod a szót?</title>
                    </head>
                    <body>
                    <div align='center'>";
        if ($meth  == "ka-lng"){
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['meaning1'];
                $trueanswer2 = $row['meaning2'];
                $beans = $row['kana'];
            }
                if($trueanswer1 == $ans || $trueanswer2 == $ans){
                    
                    $output .= "<h2>Helyes válasz!</h2>
                        <br>
                        <h3>'".$beans."' valóban azt jelenti, hogy '".$trueanswer1."'.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                $output .= "
                        <h2>Nem találtad el!</h2>
                        <br>
                        <h3>'".$beans."' azt jelenti, hogy '".$trueanswer1."'.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
            }
        }
        else if ($meth == "ka-rm"){
            $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()) {
                $trueanswer1 = $row['romanized'];
                /*$trueanswer2 = $row['roman_w'];*/
                $beans = $row['kana'];
            }
                if($trueanswer1 == $ans){
                    $output .= "
                        <h2>Helyes válasz!</h2>
                        <br>
                        <h3>'".$beans."'-t valóban úgy kell írni, hogy '".$trueanswer1."'.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                $output .= "
                        <h2>Nem találtad el!</h2>
                        <br>
                        <h3>'".$beans."'-t úgy kell írni, hogy '".$trueanswer1."'.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
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
                $trueanswer1 = $row['kana'];
                $trueanswer2 = $row['romanized'];
                $beans = $row['meaning1'];
            }
                if($trueanswer1 == $ans){
                    $output .= "
                        <h2>Helyes válasz!</h2>
                        <br>
                        <h3>'".$beans."' valóban azt jelenti, hogy '".$trueanswer1."'.</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
                }
            else {
                $output .= "<
                        <h2>Nem találtad el!</h2>
                        <br>
                        <h3>'".$beans."' azt jelenti, hogy '".$trueanswer1."' (".$trueanswer2.").</h3>
                        <form action='inc.word.game.user.dictionary.php' method='get'>
                            <input class='actionButton1' type='submit' name='' value='Következő!'>
                        </form>
                        </div>
                        </body>
                        </html>";
        }
    }
}
        echo $output;
    }
    
    
}