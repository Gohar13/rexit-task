<?php

declare(strict_types=1);

namespace RexIt\Task\Repository;

use RexIt\Task\Exception\BaseException;

class UserRepository extends BaseRepository
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
    }
    public function getData($whereClause, $bindValues = [])
    {
        $query = "SELECT favorite_category_id, firstname, lastname, email, gender, birthdate FROM users $whereClause";

        $stmt = $this->db->prepare($query);

        foreach ($bindValues as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        if (!$stmt->execute()) {
            die('Query failed: ' . print_r($stmt->errorInfo(), true));
        }

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($item) {
            $item['category'] = $this->categoryRepository->getCategoryNameById($item['favorite_category_id']);
            return $item;
        }, $data);
    }

    /**
     * @throws BaseException
     */
    public function insert($rawsData = [])
    {
        $categories = $this->categoryRepository->getAll();

        $usersValues = [];

        foreach ($rawsData as $rawData) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $rawData['birthDate'])) {
                echo "Error: Invalid date format for birthdate in row: " . implode(', ', $rawData) . "\n";
                continue;
            }
            $favorite_category_id = array_search($rawData['category'], $categories);
            $firstname = $this->db->quote($rawData['firstname']);
            $lastname = $this->db->quote($rawData['lastname']);
            $email = $this->db->quote($rawData['email']);
            $gender = $this->db->quote($rawData['gender']);
            $birthDate = $this->db->quote($rawData['birthDate']);

            $usersValues[] = "($favorite_category_id, $firstname, $lastname, $email, $gender, $birthDate)";
        }

        $query = "INSERT INTO users (favorite_category_id, firstname, lastname, email, gender, birthDate) VALUES ";

        if (!empty($usersValues)) {
            $query .= implode(',', $usersValues);

            $stmt = $this->db->query($query);

            if (!$stmt) {
                throw new BaseException($this->db->errorInfo()[2]);
            }

        } else {
            throw new BaseException('No valid data to insert');
        }
    }
}