<?php

declare(strict_types=1);

namespace RexIt\Task\Service;

use DateTime;
use Exception;
use RexIt\Task\Repository\CategoryRepository;
use RexIt\Task\Repository\UserRepository;

class UserFilterService
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

    /**
     * @throws Exception
     */
    public function filter($filter = []): ?array
    {
        $whereClause = '';
        $bindValues = [];
        if (!empty($filter)) {
            $conditions = [];

            foreach ($filter as $key => $value) {
                if ($key == 'category'){
                    $categories = $this->categoryRepository->getAll();
                    $conditions[] = 'favorite_category_id = :category';
                    $bindValues['category'] = array_search($value, $categories);

                }
                if ($key == 'gender'){
                    $conditions[] = 'gender = :gender';
                    $bindValues['gender'] = $value;
                }
                if($key == 'birthdate'){
                    $conditions[] = sprintf("%s = :%s", $key, $key);
                    $bindValues['birthdate'] = (new DateTime($value))->format('Y-m-d');
                }
                if ($key == 'age'){
                    $conditions[] = 'YEAR(CURDATE()) - YEAR(birthdate) = :age';
                    $bindValues['age'] = $value;
                }
                if($key == 'ageRange'){
                    list($minAge, $maxAge) = explode('-', $value);
                    $conditions[] = 'YEAR(CURDATE()) - YEAR(birthdate) BETWEEN :min_age AND :max_age';
                    $bindValues['min_age'] = $minAge;
                    $bindValues['max_age'] = $maxAge;
                }
            }

            $whereClause = 'WHERE '. implode(' AND ', $conditions);

        }
         return $this->userRepository->getData($whereClause, $bindValues);
    }
}