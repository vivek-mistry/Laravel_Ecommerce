<?php

namespace App\Repositories\Interfaces;

interface CouponRepositoryInterface
{
    public function createOrUpdate(array $data, string $id = null);

    public function getAll(array $with = [], $start = null, $rawperpage = null, $columnName = null, $columnSortOrder = null, $searchValue = null);

    public function getById($id);

    public function remove($id);

    public function getActiveGeneralizedCoupon();

    public function calculateCouponDiscountAmount($coupon_id, $total_sale_price);

    public function getCountOfCouponUsedByUser($user_id, $coupon_id);
}
