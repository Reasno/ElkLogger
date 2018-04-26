# ElkLogger
This packages is to be used in conjunction with laravel.

## Installation

```bash
composer require reasno\elk-logger
```

## Configuration
In your config/Logger.php, add a new channel:
```php
return [
    //...
    'custom' => [
        'driver' => 'custom',
        'via' => Reasno\ElkLogger\ElkLogger::class,
        'level' => 'info',
        'password' => "XXXXXXX",
        'host' => '127.0.0.1',
        'port' => XXXX,
        'type' => 'some unique id'
    ],
    //...
];
```
Then configure your app to use this channel for logging.
