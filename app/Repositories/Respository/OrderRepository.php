<?php

namespace App\Repositories\Respository;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function getUserOrders($user_id, array $with = [])
    {
        $order = Order::where('user_id', '=', $user_id);

        $order->with(['items']);

        if($with)
        {
            $order->with($with);
        }

        $order->orderBy('id', 'DESC');

        $result = $order->get();

        return $result;
    }

    public function getOrderById($order_id)
    {
        $order = Order::where('id', '=', $order_id);
        $order->with(['items', 'items.product', 'items.product.product_images']);
        $result = $order->first();
        return $result;
    }

    /**
     * Get All order
     *
     * @param array $with
     * @param [type] $start
     * @param [type] $rawperpage
     * @param [type] $columnName
     * @param [type] $columnSortOrder
     * @param [type] $searchValue
     * @return array
     */
    public function getAllOrder(array $with = [], $start = null, $rawperpage = null, $columnName = null, $columnSortOrder = null, $searchValue = null) : array
    {
        $order = Order::where('id', '<>', null);

        if (!empty($with)) {
            $order->with($with);
        }

        if ($searchValue) {
            $order->where('order_number', 'like', '%' . $searchValue . '%');
        }

        $clone_order = clone $order;
        $totalRecords = $clone_order->count();

        if ($rawperpage) {
            $order->take($rawperpage)->skip($start);
        }

        $result = $order->get();
        return ['total' => $totalRecords, 'data' => $result];
    }

    public function getTotalOrder()
    {
        return Order::count();
    }
}
