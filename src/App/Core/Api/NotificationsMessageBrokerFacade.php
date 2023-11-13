<?php

namespace App\Core\Api;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class NotificationsMessageBrokerFacade
{
    public function __construct()
    {
    }

    public function dispatchEmail(string $to, string $subject, string $content): void
    {
        $connection = new AMQPStreamConnection(
            NOTIFICATIONS_HOST,
            NOTIFICATIONS_PORT,
            NOTIFICATIONS_USER,
            NOTIFICATIONS_PASSWORD
        );
        $channel = $connection->channel();

        $channel->queue_declare(NOTIFICATIONS_EMAIL_QUEUE, false, true, false, false);

        $channel->basic_publish(new AMQPMessage(json_encode([
            "to" => $to,
            "subject" => $subject,
            "content" => $content
        ]), ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]), '', NOTIFICATIONS_EMAIL_QUEUE);

        $channel->close();
        $connection->close();
    }
}
