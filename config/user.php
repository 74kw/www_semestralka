<?php

class USER {


    public function __construct(){
    }
    public function isLogged(){
        if(!isset($_SESSION['userName']))
            return false;
        return true;
    }
    public function isLoggedRegistrovany(){
        if($_SESSION['userPrivileges'] === "registrovany")
            return true;
        return false;
    }
    public function isLoggedAdmin(){
        if($_SESSION['userPrivileges'] === "admin")
            return true;
        return false;
    }
    public function isLoggedRedaktor(){
        if($_SESSION['userPrivileges'] === "redaktor")
            return true;
        return false;
    }
    public function getName(){
        return $_SESSION['userName'];
    }
    public function getEmail(){
        return $_SESSION['userEmail'];
    }
    public function getPrivileges(){
        return $_SESSION['userPrivileges'];
    }
    public function LOGOUT(){
        unset($_SESSION['userName']);
        unset($_SESSION['userPrivileges']);
        unset($_SESSION['userEmail']);
        unset($_SESSION["userId"]);
        unset($_SESSION["userLastName"]);
        unset($_SESSION["userCreated"]);
    }
    public function login($userid,$username,$privileges,$useremail, $lastname, $created){
        $_SESSION["userName"] = $username;
        $_SESSION["userPrivileges"] = $privileges;
        $_SESSION["userEmail"] = $useremail;
        $_SESSION["userId"] = $userid;
        $_SESSION["userLastName"] = $lastname;
        $_SESSION["userCreated"] = $created;
    }

}
