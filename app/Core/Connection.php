<?php

declare(strict_types=1);

namespace RexIt\Task\Core;

use PDO;
use PDOException;
use RexIt\Task\Exception\BaseException;

class Connection
{
    protected static $instance;

    /**
     * @throws BaseException
     */
    private function __construct()
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME);

        try {
            self::$instance = new PDO($dsn, DB_USERNAME, DB_PASSWORD,  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $e) {

            throw new BaseException("MySql Connection Error: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            new Connection();
        }
        return self::$instance;
    }

}