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
    }