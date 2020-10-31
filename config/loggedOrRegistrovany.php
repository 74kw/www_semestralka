<?php
if (!$user->isLogged() || $user->isLoggedRegistrovany()){
    header("Location: /");
    die();
}