<?php
if (isset($_ENV['DB_HOST'])) {



//    $container->setParameter('sylius.database.driver', 'pdo_pgsql');
    $container->setParameter('database_host', $_ENV['DB_HOST']);
    $container->setParameter('database_name', $_ENV['DB_NAME']);
    $container->setParameter('database_user', $_ENV['DB_USER']);
    $container->setParameter('database_password', $_ENV['DB_PASS']);
    $container->setParameter('database_port', $_ENV['DB_PORT']);
}