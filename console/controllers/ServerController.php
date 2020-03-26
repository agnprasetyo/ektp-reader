<?php
namespace console\controllers;

use console\daemons\EchoServer;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionStart($port = null)
    {
        $server = new EchoServer();
        if ($port) {
            $server->port = $port;
        }
        echo "Server started on port : " . $server->port . PHP_EOL;
        $server->start();
    }
}
