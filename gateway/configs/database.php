<?php

return [
    /*
     * Connection settings that will be used when no one is specified:
     */
    'default' => 'mysql',

    /*
     * A simple MySQL connection using PDO.
     */
    'mysql' => [
        'driver' => \Corviz\Connector\PDO\Connection::class,

        //Options may vary according to the current driver.
        //See third party documentation for references.
        'options' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=test;charset=utf8',
            'user' => 'root',
            'password' => '',
            //'afterConnect' => function(\PDO $pdo) {
            //    //this will be executed after connect
            //},
        ],
    ],
];
