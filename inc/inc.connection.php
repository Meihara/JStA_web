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
        
        
    }