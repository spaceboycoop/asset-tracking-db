<?php

require_once('.secret/mqtt.php');

$mqtt_client = new Mosquitto\Client('asset_tracker');

/* Set the callback fired when the connection is complete */
$mqtt_client->onConnect(function($code, $message) use ($mqtt_client) {
    /* Subscribe to the broker's $SYS namespace, which shows debugging info */
    $mqtt_client->subscribe('$SYS/#', 0);
});

/* Set the callback fired when we receive a message */
$mqtt_client->onMessage(function($message) {
/* Display the message's topic and payload */
    error_log($message->topic . ': ' . $message->payload);
});

/* Connect, supplying the host and port. */
/* If not supplied, they default to localhost and port 1883 */
$mqtt_client->setCredentials($mqtt_username, $mqtt_password);
$mqtt_client->connect($mqtt_host, $mqtt_port);
