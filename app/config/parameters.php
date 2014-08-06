<?php

if (isset($_ENV['DATABASE_URL'])) {
    $dbUrl = $_ENV['DATABASE_URL'];
    $parts = parse_url($dbUrl);

//    $container->setParameter('sylius.database.driver', 'pdo_pgsql');
    $container->setParameter('database_host', $parts['host']);
    $container->setParameter('database_name', trim($parts['path'], '/'));
    $container->setParameter('database_user', $parts['user']);
    $container->setParameter('database_password', $parts['pass']);
    $container->setParameter('database_port', $parts['port']);
}