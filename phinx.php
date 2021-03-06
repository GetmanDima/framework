<?php

require_once __DIR__ . '/config/db.php';


return [
    'paths' => [
        'migrations' => './database/migrations',
        'seeds' => './database/seeders'
    ],

    'environments' => [
        'default_migration_table' => 'migrations',
        'production' => [
            'adapter' => 'mysql',
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USER,
            'pass' => DB_PASSWORD,
            'port' => DB_PORT,
            'charset' => 'utf8',
            'table_prefix' => ''
        ],

        'development' => [
            'adapter' => 'mysql',
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USER,
            'pass' => DB_PASSWORD,
            'port' => DB_PORT,
            'charset' => 'utf8',
            'table_prefix' => ''
        ]
    ],
];