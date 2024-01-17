<?php

declare(strict_types=1);

namespace RexIt\Task\Exception;

class BaseException extends \Exception
{

    /**
     * Prints validation error's message.
     */
    public function log(): void
    {
        echo 'ERROR: ' . $this->message.PHP_EOL;
    }
}
