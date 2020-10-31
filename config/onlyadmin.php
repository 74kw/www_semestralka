<?php
if (!$user->isLoggedAdmin()){
    header("Location: /");
    die();
}