<?php

return array(

    'default' => 'sqlite',

    'connections' => array(

        'sqlite' => array(
            'driver'    => 'sqlite',
            'database'  => ':memory:',
            'prefix'    => '',
        ),

    'test' => array(
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'test_db',
        'username'  => 'test_user',
        'password'  => 'test_pw',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        ),
    ),
);
