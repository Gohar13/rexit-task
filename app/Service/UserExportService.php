<?php

declare(strict_types=1);

namespace RexIt\Task\Service;

use RexIt\Task\Repository\CategoryRepository;
use RexIt\Task\Repository\UserRepository;

class UserExportService
{
    protected UserRepository $userRepository;
    protected CategoryRepository $categoryRepository;
    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function export($usersData): string
    {
        $csvFilePath = '../exported_data.csv';

        $csvFile = fopen($csvFilePath, 'w');

        fputcsv($csvFile, ['category', 'firstname', 'lastname', 'email', 'gender', 'birthDate']);

        foreach ($usersData as $userData) {

            $csvRow = [
                'category' => $this->categoryRepository->getCategoryNameById($userData['favorite_category_id']),
                'firstname' => $userData['firstname'],
                'lastname' => $userData['lastname'],
                'email' => $userData['email'],
                'gender' => $userData['gender'],
                'birthDate' => $userData['birthdate'],
            ];

            fputcsv($csvFile, $csvRow);
        }

        fclose($csvFile);

        return $csvFilePath;
    }
}
