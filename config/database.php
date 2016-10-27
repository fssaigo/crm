<?php

return [

        /*
        |--------------------------------------------------------------------------
        | PDO Fetch Style
        |--------------------------------------------------------------------------
        |
        | By default, database results will be returned as instances of the PHP
        | stdClass object; however, you may desire to retrieve records in an
        | array format for simplicity. Here you can tweak the fetch style.
        |
        */

    'fetch' => PDO::FETCH_OBJ,

        /*
        |--------------------------------------------------------------------------
        | Default Database Connection Name
        |--------------------------------------------------------------------------
        |
        | Here you may specify which of the database connections below you wish
        | to use as your default connection for all database work. Of course
        | you may use many connections at once using the Database library.
        |
        */

    'default' => env('DB_CONNECTION', 'mysql'),

        /*
        |--------------------------------------------------------------------------
        | Database Connections
        |--------------------------------------------------------------------------
        |
        | Here are each of the database connections setup for your application.
        | Of course, examples of configuring each database platform that is
        | supported by Laravel is shown below to make development simple.
        |
        |
        | All database work in Laravel is done through the PHP PDO facilities
        | so make sure you have the driver for your particular database of
        | choice installed on your machine before you begin development.
        |
        */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '120.76.225.50'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'canyin'),
            'username' => env('DB_USERNAME', 'canyin'),
            'password' => env('DB_PASSWORD', 'canyin123'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        '91' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_CANYIN', '116.255.205.66'),
            'port' => env('DB_PORT_CANYIN', '3306'),
            'database' => env('DB_DATABASE_CANYIN', '91canyin'),
            'username' => env('DB_USERNAME_CANYIN', '91canyin'),
            'password' => env('DB_PASSWORD_CANYIN', 'FM3#214&Jmsddk'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'zone' => [
            'driver' => 'mysql',
            'host' => env('DB_DATABASE_ZONE', '120.76.225.50'),
            'port' => env('DB_DATABASE_ZONE', '3306'),
            'database' => env('DB_DATABASE_ZONE', '91analytics'),
            'username' => env('DB_DATABASE_ZONE', '91canyin'),
            'password' => env('DB_DATABASE_ZONE', 'FM3#214&Jmsddk'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'call' => [
            'driver' => 'mysql',
            'host' => env('DB_DATABASE_CALL', '116.255.205.66'),
            'port' => env('DB_DATABASE_CALL', '3306'),
            'database' => env('DB_DATABASE_CALL', '91canyin'),
            'username' => env('DB_DATABASE_CALL', 'call'),
            'password' => env('DB_DATABASE_CALL', 'FM3#214&Jmsddk'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

    ],

        /*
        |--------------------------------------------------------------------------
        | Migration Repository Table
        |--------------------------------------------------------------------------
        |
        | This table keeps track of all the migrations that have already run for
        | your application. Using this information, we can determine which of
        | the migrations on disk haven't actually been run in the database.
        |
        */

    'migrations' => 'migrations',

        /*
        |--------------------------------------------------------------------------
        | Redis Databases
        |--------------------------------------------------------------------------
        |
        | Redis is an open source, fast, and advanced key-value store that also
        | provides a richer set of commands than a typical key-value systems
        | such as APC or Memcached. Laravel makes it easy to dig right in.
        |
        */

    'redis' => [

        'cluster' => false,

        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];