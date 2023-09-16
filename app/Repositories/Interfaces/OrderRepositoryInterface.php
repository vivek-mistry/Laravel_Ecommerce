<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function getUserOrders($user_id, array $with = []);

    public function getOrderById($order_id);

    public function getAllOrder(array $with = [], $start = null, $rawperpage = null, $columnName = null, $columnSortOrder = null, $searchValue = null);

    public function getTotalOrder();
}
