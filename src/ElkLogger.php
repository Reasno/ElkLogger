<?php

namespace Reasno\ElkLogger;

use Monolog\Logger;
use Monolog\Handler\RedisHandler;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Processor\PsrLogMessageProcessor;
use Predis\Client;

class ElkLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        // Init a RedisHandler with a LogstashFormatter.
        // The parameters may differ depending on your configuration of Redis.
        // Important: The parameter 'logs' must be equal to the key you defined
        // in your logstash configuration.
        $client = new Client([
            'scheme' => 'tcp',
            'host'   => $config['host'],
            'port'   => $config['port'],
        ]);

        $client->auth($config['password']);

        $redisHandler = new RedisHandler($client, 'logstash');
        $formatter = new LogstashFormatter($config['type']);
        $processor = new PsrLogMessageProcessor();
        $redisHandler->setFormatter($formatter);
        $redisHandler->pushProcessor($processor);
        return new Logger($config['type'], [$redisHandler]);
    }
}
