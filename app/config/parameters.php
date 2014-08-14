<?php
if (isset($_ENV['DB_HOST'])) {

//    $container->setParameter('sylius.database.driver', 'pdo_pgsql');
    $container->setParameter('database_host', $_ENV['DB_HOST']);
    $container->setParameter('database_name', $_ENV['DB_NAME']);
    $container->setParameter('database_user', $_ENV['DB_USER']);
    $container->setParameter('database_password', $_ENV['DB_PASS']);
    $container->setParameter('database_port', $_ENV['DB_PORT']);
}

if (isset($_ENV['MANDRILL_SUBACCOUNT'])) {
    $container->setParameter('mandrill_subaccount', $_ENV['MANDRILL_SUBACCOUNT']);
}

if (isset($_ENV['SIESC_INSTITUCION'])) {
    $container->setParameter('institucion', $_ENV['SIESC_INSTITUCION']);
    $container->setParameter('project_code', $_ENV['SIESC_INSTITUCION_CODE']);
}