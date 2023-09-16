<?php

namespace App\Repositories\Interfaces;

interface UserAddressRepositoryInterface
{
    public function createOrUpdate(array $data, string $id = null);

    public function getDefaultAddress($user_id);

    public function getUserAllAddress($user_id, bool $except_is_default = null);

    public function getById($id);

    public function oneAddressCanActive($user_id, $user_address_id);
}
