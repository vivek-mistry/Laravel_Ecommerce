<?php

namespace App\Repositories\Respository;

use App\Models\Coupon;
use App\Models\UsedCoupon;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Carbon\Carbon;

class CouponRepository implements CouponRepositoryInterface
{
    /**
     * Create or update Coupon
     *
     * @param array $data
     * @param string|null $id
     * @return Coupon
     */
    public function createOrUpdate(array $data, string $id = null): Coupon
    {
        if (!isset($id)) {
            $coupon = new Coupon($data);
        } else {
            $coupon = Coupon::find($id);

            foreach ($data as $key => $value) {
                $coupon->$key = $value;
            }
        }
        $coupon->save();
        return $coupon;
    }

    /**
     * Get All coupon
     *
     * @param array $with
     * @param [type] $start
     * @param [type] $rawperpage
     * @param [type] $columnName
     * @param [type] $columnSortOrder
     * @param [type] $searchValue
     * @return array
     */
    public function getAll(array $with = [], $start = null, $rawperpage = null, $columnName = null, $columnSortOrder = null, $searchValue = null): array
    {
        $coupon = Coupon::where('id', '<>', null);

        if (!empty($with)) {
            $coupon->with($with);
        }

        if ($searchValue) {
            $coupon->where('coupon_code', 'like', '%' . $searchValue . '%');
        }

        $clone_coupon = clone $coupon;
        $totalRecords = $clone_coupon->count();

        if ($rawperpage) {
            $coupon->take($rawperpage)->skip($start);
        }

        $result = $coupon->get();
        return ['total' => $totalRecords, 'data' => $result];
    }

    /**
     * Find by id
     *
     * @param [type] $id
     * @return mixed
     */
    public function getById($id): mixed
    {
        return Coupon::find($id);
    }

    /**
     * Remove
     *
     * @param [type] $id
     * @return void
     */
    public function remove($id)
    {
        return Coupon::destroy($id);
    }

    /**
     * Get All Generalized Active Coupon
     *
     * @return mixed
     */
    public function getActiveGeneralizedCoupon(): mixed
    {
        $coupons = Coupon::where('coupon_type', '=', Coupon::COUPON_TYPE_GENERALIZED);

        $coupons->where('is_active', '=', 1);

        $coupons->where('expired_at', '>=', Carbon::now()->format('Y-m-d'));

        $result = $coupons->get();

        return $result;
    }

    public function calculateCouponDiscountAmount($coupon_id, $total_sale_price)
    {
        $coupon = $this->getById($coupon_id);

        $total_discount = number_format(0, 2);
        if ($coupon->discount_type === Coupon::DISCOUNT_TYPE_PER) {
            $total_discount = number_format(($total_sale_price * $coupon->discount) / 100, 2);

            if ($total_discount > $coupon->max_discount_amount) {
                $total_discount = $coupon->max_discount_amount;
            }
        }

        if ($coupon->discount_type === Coupon::DISCOUNT_TYPE_AMOUNT) {
            $total_discount = $coupon->discount;
        }
        return $total_discount;
    }

    public function getCountOfCouponUsedByUser($user_id, $coupon_id)
    {
        $coupon = UsedCoupon::where('coupon_id', $coupon_id);

        $coupon->where('user_id', $user_id);

        return $coupon->count();
    }
}
