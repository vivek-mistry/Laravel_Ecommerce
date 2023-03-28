<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function createOrUpdate(array $data, string $id = null);

    public function getAllUser(array $with = [], $start = null, $rawperpage = null, $columnName = null, $columnSortOrder = null, $searchValue = null, array $user_roles = []);

    public function getById($id);

    public function getUserByField(string $field_name, string $field_value);

    public function getTotalUsers();
}
