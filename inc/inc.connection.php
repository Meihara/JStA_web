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
    
    function dictionaryFillEn() {
        $conn = $this->connect();
        $sql = "SELECT * FROM words";
        $output = ' ';
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<tr><th>'.$row['id_word'].'</th><th class="th1">'.$row['kana_w'].'</th><th class="th1">'.$row['roman_w'].'</th>';
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
            $output .= '<tr><th>'.$row['id_word'].'</th><th class="th1">'.$row['kana_w'].'</th><th class="th1">'.$row['roman_w'].'</th>';
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
}