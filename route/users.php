<?php

declare(strict_types=1);

use RexIt\Task\Controller\UserController;
use RexIt\Task\Repository\CategoryRepository;
use RexIt\Task\Repository\UserRepository;
use RexIt\Task\Service\UserExportService;
use RexIt\Task\Service\UserFilterService;

require_once '../vendor/autoload.php';
require_once '../config/app.php';

$uri = $_SERVER['SCRIPT_NAME'];

if ($uri === '/users.php') {

    $queryArray = [];

    if ($_SERVER['QUERY_STRING']) {
        parse_str($_SERVER['QUERY_STRING'], $queryArray);
    }

    $categoryRepository = new CategoryRepository();
    $userRepository = new UserRepository($categoryRepository);
    $userController = new UserController(
        new UserFilterService(
            $userRepository,
            $categoryRepository
        ),
        new UserExportService(
            $userRepository,
            $categoryRepository
        )
    );
    $result = $userController->search($queryArray);

    require_once('../views/index.php');
}
elseif($uri !== '/index.php') {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Route not found']);
}


