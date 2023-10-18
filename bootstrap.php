<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use MoolrePayments\Core\Database;

$dotEnv = Dotenv::createImmutable(__DIR__);
$dotEnv->load();

$customers = <<<EOS
    CREATE TABLE IF NOT EXISTS customers (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) DEFAULT 'PENDING',
        pub_key VARCHAR(100) NOT NULL,
        sec_key VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        is_approved BOOLEAN NOT NULL,
        PRIMARY KEY (id),
    ) ENGINE=INNODB;
EOS;

$payments = <<<EOS
    CREATE TABLE IF NOT EXISTS payments (
        id INT NOT NULL AUTO_INCREMENT,
        status VARCHAR(100) DEFAULT 'PENDING',
        customer_reference VARCHAR(100) NOT NULL,
        platform_reference VARCHAR(100) NOT NULL,
        gateway_reference VARCHAR(100) NOT NULL,
        customer_id INT DEFAULT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (customer_id)
            REFERENCES customers(id)
            ON DELETE SET NULL,
    ) ENGINE=INNODB;
EOS;

$statements = [$customers, $payments];

$database = new Database();
foreach ($statements as $s) {
    $database->query($s)->first();
}

