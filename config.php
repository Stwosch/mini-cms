<?php

// DATABASE CONFIGURATION

define('DB_SERVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tiles');

// AUTOLOAD

set_include_path(get_include_path(). PATH_SEPARATOR . "model");
set_include_path(get_include_path(). PATH_SEPARATOR . "view");
set_include_path(get_include_path(). PATH_SEPARATOR . "router");
set_include_path(get_include_path(). PATH_SEPARATOR . "controller");

function __autoload($className) {
    require_once($className.".class.php");
}