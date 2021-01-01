<?php

class Connection {
    
    function connect(){
        $conn = new mysqli("localhost", "root", "", "jsta_database") or die("Couldn't establish connection!");
        return $conn;
    }
    function signup($uid, $pwd, $dLang)
    {
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
            if($dLang == 0){
                header("Location: ../en/en.dashboard.php");
            }
            else{
            header("Location: ../hu/hu.dashboard.php");
            }
            }
        //echo $uid."<br>".$pwd."<br>".$dLang."<br>".$userExistsSql;
        }
        
        
    }