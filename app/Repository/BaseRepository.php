<?php

declare(strict_types=1);

namespace RexIt\Task\Repository;

use RexIt\Task\Core\Connection;

abstract class BaseRepository
{
    protected $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }
}