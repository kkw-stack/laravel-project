<?php

return [
    'default' => env('LOG_CHANNEL', 'stack'),
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => 'php://stdout',
            'tap' => env('LOG_STDERR_FORMATTER'),
            'level' => 'debug',
        ],
    ]
];