<?php

namespace RexIt\Task\Controller;

use RexIt\Task\Service\UserExportService;
use RexIt\Task\Service\UserFilterService;

class UserController
{
    protected UserFilterService $userFilter;
    protected UserExportService $userExport;

    public function __construct(
        UserFilterService $userFilter,
        UserExportService $userExport
    )
    {
        $this->userFilter = $userFilter;
        $this->userExport = $userExport;
    }

    /**
     * @throws \Exception
     */
    public function search($queryParams): ?array
    {
        $export = isset($queryParams['export']) &&  filter_var($queryParams['export'], FILTER_VALIDATE_BOOLEAN);
        unset($queryParams['export']);
        $usersData = $this->userFilter->filter($queryParams);

        if($export){
            $file = $this->userExport->export($usersData);
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"exported_data.csv\"");
            echo readfile($file);
        }

        return $usersData;
    }
}