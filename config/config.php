<?php
define('ROOT_PATH', realpath(dirname(__FILE__)));

define('DB_HOST', 'localhost');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_NAME','semestralka');

ob_start();
session_start();

include_once ("db.php");

$db = new DB();
