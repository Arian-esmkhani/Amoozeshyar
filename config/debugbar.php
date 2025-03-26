<?php

return [
    'enabled' => env('DEBUGBAR_ENABLED', null),
    'collectors' => [
        'phpinfo' => true,  // Php version
        'messages' => true, // Messages
        'time' => true,     // Time Datalogger
        'memory' => true,   // Memory usage
        'exceptions' => true, // Exception displayer
        'log' => true,      // Logs from Monolog (merged in messages if enabled)
        'db' => true,       // Show database (PDO) queries and bindings
        'views' => true,    // Views with their data
        'route' => true,    // Current route information
        'auth' => false,    // Display Laravel authentication status
        'gate' => true,     // Display Laravel Gate checks
        'session' => true,  // Display session data
        'symfony_request' => true, // Only one can be enabled..
        'mail' => true,     // Catch mail messages
        'laravel' => true, // Laravel version and environment
        'events' => true, // All events fired
        'default_request' => false, // Regular or special Symfony request logger
        'logs' => true, // Add the latest log messages
        'files' => false, // Show the included files
        'config' => true, // Display config settings
        'cache' => true, // Display cache events
        'models' => true,  // Display models
        'livewire' => true, // Display Livewire (if installed)
    ],

    'options' => [
        'queries' => [
            'timeline' => true,  // Add the queries to the timeline
            'backtrace' => true, // EXPERIMENTAL: Use a backtrace to find the origin of the query in your code.
            'explain' => true,   // EXPLAIN select query
            'hints' => true,     // Show hints for common mistakes
        ],
        'db' => [
            'backtrace' => true, // EXPERIMENTAL: Use a backtrace to find the origin of the query in your code.
        ],
        'mail' => [
            'full_log' => false,
        ],
        'views' => [
            'data' => false, //Note: Can slow down the application, because the data can be quite large..
        ],
        'route' => [
            'label' => true, // show complete route on bar
        ],
        'logs' => [
            'daily' => true,
        ],
        'cache' => [
            'values' => true, // collect cache values
        ],
    ],

    'inject' => true, // Inject the debugbar (usually disabled in production)
    'route_prefix' => '_debugbar', // The debugbar route prefix
    'route_domain' => null, // The debugbar route domain
    'theme' => 'auto', // DEPRECATED: Set this to any of the themes now instead
    'debug_backtrace_limit' => 50, // Limit the number of frames collected by the debugger
    'debug_backtrace_provider' => null, // The debug backtrace provider
    'http_driver' => 'auto', // The driver used to capture HTTP requests for the debugbar
    'capture_ajax' => true,
    'capture_commands' => false,
    'include_vendors' => true,
    'clockwork' => false, // Enable Clockwork integration
    'clockwork_laravel' => false,
    'clockwork_extra' => [], // Extra data to send to Clockwork
    'spark' => false, // Enable Laravel Spark integration
    'default' => 'php', // DEPRECATED: Use 'clockwork' instead
    'capture_console' => true,
    'console_show_queries' => false,
    'console_sql_queries' => true,
    'console_style' => 'auto',
    'explorer' => [
        'enabled' => false,
        'hidden' => [],
    ],
    'remote_sites_path' => '',
];
