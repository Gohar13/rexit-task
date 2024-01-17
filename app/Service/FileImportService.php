<?php

declare(strict_types=1);

namespace RexIt\Task\Service;

use RexIt\Task\Exception\BaseException;
use RexIt\Task\Repository\CategoryRepository;
use RexIt\Task\Repository\UserRepository;

class FileImportService
{
    protected UserRepository $userRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @throws BaseException
     */
    public function import(string $file): void
    {
        $data = file_get_contents($file);
        $rows = explode("\n", $data);

        $rawsData = [];

        $headers = explode(',', array_shift($rows));

        foreach ($rows as $row) {
            $values = explode(',', $row);
            $values = array_map('trim', $values);

            if (count($values) === count($headers)) {
                $rawsData[] = array_combine($headers, $values);
            } else {
                throw new BaseException('Invalid data format in row');
            }
        }

        $categories = array_column($rawsData, 'category');
        $uniqueCategories = array_unique($categories);

        $this->categoryRepository->insert($uniqueCategories);
        $this->userRepository->insert($rawsData);
    }
}
