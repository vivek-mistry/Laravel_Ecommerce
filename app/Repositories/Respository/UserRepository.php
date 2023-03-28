<?php

namespace App\Repositories\Respository;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create or update user
     *
     * @param array $data
     * @param string|null $id
     * @return User
     */
    public function createOrUpdate(array $data, string $id = null) : User
    {
        if (!isset($id)) {
            $user = new User($data);
        } else {
            $user = User::find($id);

            foreach ($data as $key => $value) {
                $user->$key = $value;
            }
        }
        $user->save();
        return $user;
    }

    /**
     * Get All Users
     *
     * @param array $with
     * @param [type] $start
     * @param [type] $rawperpage
     * @param [type] $columnName
     * @param [type] $columnSortOrder
     * @param [type] $searchValue
     * @param array $user_roles
     * @return array
     */
    public function getAllUser(array $with = [], $start = null, $rawperpage = null, $columnName = null, $columnSortOrder = null, $searchValue = null, array $user_roles = []): array
    {
        $user = User::where('id', '<>', null)->with(['user_roles']);

        if($user_roles)
        {
            $user->whereHas('user_roles', function ($query) use ($user_roles){
                $query->whereIn('role_name', $user_roles);
            });
        }

        if (!empty($with)) {
            $user->with($with);
        }

        if ($searchValue) {
            $user->where('name', 'like', '%' . $searchValue . '%');
            $user->orWhere('phone_number', 'like', '%' . $searchValue . '%');
            $user->orWhere('email', ' ', '%' . $searchValue . '%');
        }

        $clone_user = clone $user;
        $totalRecords = $clone_user->count();

        if ($rawperpage) {
            $user->take($rawperpage)->skip($start);
        }

        $result = $user->get();
        return ['total' => $totalRecords, 'data' => $result];
    }

    /**
     * Find by id
     *
     * @param [type] $id
     * @return mixed
     */
    public function getById($id) :mixed
    {
        return User::find($id);
    }

    public function getUserByField(string $field_name, string $field_value)
    {
        return User::where($field_name, '=', $field_value)->first();
    }

    public function getTotalUsers()
    {
        return User::count();
    }
}
