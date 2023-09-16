<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    public function createOrUpdate(array $data, string $id = null);

    public function getUserCartList();

    public function getRowByWhere(array $where);
}
