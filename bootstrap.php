<?php
define('_DIR_ROOT', str_replace('\\', '/', __DIR__)); // Đường dẫn thư mục gốc
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $_web_root = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $_web_root = 'http://' . $_SERVER['HTTP_HOST'];
}
$folder = str_replace($_SERVER['DOCUMENT_ROOT'], '', _DIR_ROOT);
$_web_root = $_web_root . $folder;
define('_WEB_ROOT', $_web_root); // Đường dẫn web
require_once 'app/config/pdo.php';
require_once 'app/core/Controller.php';
require_once 'app/config/routes.php';
require_once 'app/core/Route.php';
require_once 'app/App.php';