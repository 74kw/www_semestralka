<?php

class DB {

private $conn;

    public function __construct(){
        $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function userExist($email){
        $sql = "SELECT COUNT(email) AS num FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row['num'] > 0){
            return true;
        }else{
            return false;
        }
    }
    public function insertUser($email, $pswd,$name,$lastName){
        $sql = "INSERT INTO users (email, password, privileges, name,lastName) VALUES (?,?,?,?,?)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$email, $pswd, 'registrovany',$name,$lastName]);
    }
    public function getUser($email){
        $sql = "SELECT email, password,privileges, name,lastName FROM users WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetch();
    }

}
