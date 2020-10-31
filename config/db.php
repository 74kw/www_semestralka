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
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetch();
    }
    public function getAllTags(){
        $sql = "SELECT * FROM tags";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetchAll();
    }
    public function insertTag($name){
        $sql = "INSERT INTO tags (name) VALUES (?)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$name]);
    }
    public function insertArticleTag($idTag,$idArticle){
        $sql = "INSERT INTO articles_tags (idTags, idArticles) VALUES (?,?)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$idTag, $idArticle]);
    }
    public function insertArticle($title, $description,$content,$userid){
        $sql = "INSERT INTO articles (title, description, content,idUsers) VALUES (?,?,?,?)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$title, $description, $content,$userid]);
        $last_id = $this->conn->lastInsertId();
        return $last_id;
    }
    public function getNextArticleID(){
        $sql = "SELECT AUTO_INCREMENT
                FROM information_schema.TABLES
                WHERE TABLE_SCHEMA = \"semestralka\"
                AND TABLE_NAME = \"tags\"";
        $stmt= $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetch();



    }

}
