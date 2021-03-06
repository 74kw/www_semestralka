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
    public function insertUserWithPrivileges($email, $pswd,$name,$lastName,$privileges){
        $sql = "INSERT INTO users (email, password, privileges, name,lastName) VALUES (?,?,?,?,?)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$email, $pswd, $privileges,$name,$lastName]);
    }
    public function getUser($email){
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetch();
    }
    public function getUserById($id){
        $sql = "SELECT * FROM users WHERE idUsers=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
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
    public function getArticle($id){
        $sql = "SELECT * FROM articles WHERE idArticles=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetch();
    }
    public function getArticleTags($idArticle){
        $sql = "SELECT * FROM articles_tags WHERE idArticles=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetchAll();
    }
    public function getTag($idTag){
        $sql = "SELECT * FROM tags WHERE idTags=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idTag]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetch();
    }
    public function getAllArticles(){
        $sql = "SELECT * FROM articles";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetchAll();
    }
    public function deleteArticleComplet($idArticle){
        $sql = "DELETE FROM comments WHERE idArticles=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);

        $sql = "DELETE FROM articles_tags WHERE idArticles=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);

        $sql = "DELETE FROM rating WHERE idArticles=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);

        $sql = "DELETE FROM articles WHERE idArticles=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);
    }

    public function updateArticle($title, $description,$content,$userid, $idArticle){
        $sql = "UPDATE articles SET title = ?, description = ?, content = ?,idUsers = ? WHERE idArticles=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$title, $description, $content,$userid,$idArticle]);
    }
    public function deleteArticleTagsByTagID($idTag){
        $sql = "DELETE FROM articles_tags WHERE idTags=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idTag]);
    }
    public function deleteTag($idTag){
        $sql = "DELETE FROM tags WHERE idTags=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idTag]);
    }
    public function updateTag($name,$idTag){
        $sql = "UPDATE tags SET name = ? WHERE idTags=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$name,$idTag]);
    }
    public function getAllArticlesTags(){
        $sql = "SELECT * FROM articles_tags";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetchAll();
    }
    public function deleteArticleTagsByTagIDAndArticleId($idTag,$idArticle){
        $sql = "DELETE FROM articles_tags WHERE idTags=? AND idArticles=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idTag,$idArticle]);
    }
    public function updateArticleTag($idTagNew,$idArticlesNew,$idTagOld,$idArticlesOld){
        $sql = "UPDATE articles_tags SET idTags = ?, idArticles = ? WHERE idTags=? AND idArticles = ?";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$idTagNew,$idArticlesNew,$idTagOld,$idArticlesOld]);
    }
    public function getAllUsers(){
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetchAll();
    }
    public function deleteUserComplet($idUsers){
        $sql = "DELETE FROM comments WHERE idUsers=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idUsers]);

        $sql = "DELETE FROM rating WHERE idUsers=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idUsers]);

        $sql = "DELETE FROM users WHERE idUsers=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idUsers]);
    }
    public function updateUser($email,$password,$privileges,$name,$lastName, $idUsers){
        $sql = "UPDATE users SET email = ?, password = ?, privileges = ?,name = ?,lastName = ?  WHERE idUsers=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$email, $password, $privileges,$name,$lastName,$idUsers]);
    }
    public function getArticleRating($idArticle){
        $sql = "SELECT * FROM rating WHERE idArticles= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $count = 0;
        $doublePrumer = 0;
        foreach ($result as $row) {
            $count++;
            $doublePrumer += $row['value'];
        }
        if ($count> 0)
            return array(round($doublePrumer/$count,1),$count);
        return array(0,0);
    }
    public function getArticleRatingV2($idArticle){
        $sql = "SELECT SUM(value) as value FROM rating WHERE idArticles= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        $sum = $result['value'];

        $sql = "SELECT COUNT(value) as value FROM rating WHERE idArticles= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        $count = $result['value'];

        if ($count> 0)
            return array(round($sum/$count,1),$count);
        return array($count,$count);
    }
    public function getUserAlreadyRate($idArticle,$idUser){
        $sql = "SELECT * FROM rating WHERE idArticles= ? AND idUsers = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle,$idUser]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();

        if (isset($result['idUsers'])) {
            return true;
        } else {
            return false;
        }
    }
    public function insertRating($value,$idArticle,$idUser){
        $sql = "INSERT INTO rating (value, idUsers, idArticles) VALUES (?,?,?)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$value,$idUser,$idArticle,]);
    }
    public function getUserArticleRate($idArticle,$idUser){
        $sql = "SELECT * FROM rating WHERE idArticles= ? AND idUsers = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle,$idUser]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();

        return $result['value'];
    }
    public function insertComment($content,$idArticle,$idUser){
        $sql = "INSERT INTO comments (content, idUsers, idArticles) VALUES (?,?,?)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$content,$idUser,$idArticle,]);
    }
    public function getAllArticleComments($idArticle){
        $sql = "SELECT comments.idComments,comments.content, comments.created, users.name,
                users.lastName, users.privileges
                FROM comments
                INNER JOIN users ON comments.idUsers=users.idUsers WHERE idArticles = ?
                ORDER BY created ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetchAll();
    }
    public function deleteComment($idComment){
        $sql = "DELETE FROM comments WHERE idComments = ?";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$idComment]);
    }
    public function getAllArticleByCreated(){
        $sql = "SELECT articles.idArticles,articles.title, articles.description, articles.content,
		        articles.created, users.name, users.lastName, users.privileges
                FROM articles
                INNER JOIN users ON articles.idUsers=users.idUsers
                ORDER BY created DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetchAll();
    }
    public function getAllArticleByTagSortedByCreated($idTag){
        $sql = "SELECT articles_tags.idTags, articles.idArticles, articles.title,
                articles.description,articles.content,articles.created, articles.idUsers
                FROM articles_tags
                INNER JOIN articles ON articles_tags.idArticles = articles.idArticles
                WHERE articles_tags.idTags = ?
                ORDER BY created DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idTag]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetchAll();
    }
    public function getArticleCommentsCount($idArticle){
        $sql = "SELECT COUNT(idComments) FROM comments WHERE idArticles = ?";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$idArticle]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $result = $stmt->fetchColumn();
    }


}
