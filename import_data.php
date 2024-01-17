<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'config/app.php';

use RexIt\Task\Exception\BaseException;
use RexIt\Task\Exception\FileNotFoundException;
use RexIt\Task\Exception\InvalidFileException;
use RexIt\Task\Repository\CategoryRepository;
use RexIt\Task\Repository\UserRepository;
use RexIt\Task\Service\FileImportService;

try {

    if ($argc !== 2) {
        throw new InvalidFileException('File is required!');
    }

    $file = $argv[1];

    if (!file_exists($file)) {
        throw new FileNotFoundException('File not found!');
    }

    if (pathinfo($file, PATHINFO_EXTENSION) !== 'csv') {
        throw new InvalidFileException('Invalid file format. Only CSV files are supported!');
    }
    $categoryRepository = new CategoryRepository();
    $userRepository = new UserRepository($categoryRepository);

    $importService = new FileImportService($userRepository, $categoryRepository);
    $importService->import($file);

} catch (BaseException $exception) {
    $exception->log();
}






