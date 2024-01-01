<?php
session_start();
require_once realpath(__DIR__ . '/vendor/autoload.php');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once 'bootstrap.php';
$app = new App();
ob_end_flush(); ?>