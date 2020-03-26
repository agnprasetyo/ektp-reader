<?php
namespace console\daemons;

use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\events\WSClientMessageEvent;
use consik\yii2websocket\WebSocketServer;

class EchoServer extends WebSocketServer
{

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_CLIENT_CONNECTED, function (WSClientEvent $e) {
            $e->client->name = null;
            echo 'Client Connected' . PHP_EOL;
            $json = json_encode([
                'name' => $e->name,
                'sender' => $e->sender,
            ]);

            print_r($json);
            echo PHP_EOL;
        });

        $this->on(self::EVENT_CLIENT_MESSAGE, function (WSClientMessageEvent $e) {
            foreach ($this->clients as $client) {
                $client->send( $e->message );
            }
        });
    }


}
