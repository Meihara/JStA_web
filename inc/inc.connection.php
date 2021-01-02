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

            header("Location: ../index.php");
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

            header("Location: ../index.php");
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
            $langL = $_SESSION['lang'];
            session_unset();
            session_destroy();
                require "static/static.message.pwchanged.php";
        }
        else {
            header("Location: ../index.php");
        }
         
    }
        
        
    }