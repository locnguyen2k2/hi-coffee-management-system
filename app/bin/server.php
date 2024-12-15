<?php
require dirname(__DIR__) . '/../vendor/autoload.php';

use HiCoffeeOrder\core\HiCoffeeSocket;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            HiCoffeeSocket::getInstance()
        )
    ),
    8080
);
$server->run();