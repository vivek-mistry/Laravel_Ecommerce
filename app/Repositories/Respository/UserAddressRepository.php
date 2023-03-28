<?php

namespace App\Repositories\Respository;

use App\Models\User;
use App\Models\UserAddress;
use App\Repositories\Interfaces\UserAddressRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserAddressRepository implements UserAddressRepositoryInterface
{
    /**
     * Create or update UserAddress
     *
     * @param array $data
     * @param string|null $id
     * @return UserAddress
     */
    public function createOrUpdate(array $data, string $id = null): UserAddress
    {
        if (!isset($id)) {
            $user_address = new UserAddress($data);
        } else {
            $user_address = UserAddress::find($id);

            foreach ($data as $key => $value) {
                $user_address->$key = $value;
            }
        }
        $user_address->save();
        return $user_address;
    }

    /**
     * Get Default Address
     *
     * @return mixed
     */
    public function getDefaultAddress($user_id): mixed
    {
        $user_address = UserAddress::where('is_default', '=', 1);

        $user_address->where('user_id', '=', $user_id);

        $result = $user_address->first();

        return $result;
    }

    /**
     * Get all user address
     *
     * @param [type] $user_id
     * @param boolean|null $except_is_default
     * @return mixed
     */
    public function getUserAllAddress($user_id, bool $except_is_default = null): mixed
    {
        $user_address = UserAddress::where('user_id', '=', $user_id);

        if ($except_is_default) {
            $user_address->where('is_default', '=', 0);
        }

        $result = $user_address->get();

        return $result;
    }

    /**
     * Get By id
     *
     * @param [type] $id
     * @return void
     */
    public function getById($id)
    {
        return UserAddress::find($id);
    }

    public function oneAddressCanActive($user_id, $user_address_id)
    {
        return UserAddress::where('user_id', '=', $user_id)
            ->where('is_default', '=', 1)
            ->where('id', '!=', $user_address_id)
            ->update(
                [
                    'is_default' => 0
                ]
            );
    }
}
