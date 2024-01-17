<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'config/app.php';

use RexIt\Task\Core\Connection;

$conn = Connection::getInstance();

$categoryTableCreateQuery = "CREATE TABLE IF NOT EXISTS categories (
    id int NOT NULL AUTO_INCREMENT,
    name VARCHAR(20),
    PRIMARY KEY (id)
) ENGINE=INNODB";

$stmt = $conn->prepare($categoryTableCreateQuery);

if (!$stmt->execute()) {
    throw new Exception('Categories table creation failed.');
}

$usersTableCreateQuery = "CREATE TABLE IF NOT EXISTS users (
    id int NOT NULL AUTO_INCREMENT,
    favorite_category_id int,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255),
    gender VARCHAR(6),
    birthdate DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (favorite_category_id) REFERENCES categories(id)
) ENGINE=INNODB";

$stmt = $conn->prepare($usersTableCreateQuery);

if ($stmt->execute()) {
    echo "Migration successfully run." . "\n";
} else {
    echo "Migration failed." . "\n";
}