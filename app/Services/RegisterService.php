<?php

namespace App\Services;

use App\Models\UserRoleMapping;
use App\Models\UserRoles;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class RegisterService
{

    /**
     * @var UserRepositoryInterface
     */
    public $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function createUser($request, string $user_role_name = null)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password)
        ];

        $user = $this->userRepository->createOrUpdate($data);

        if($user_role_name)
        {
            $user_role = $this->loadUserRole($user_role_name);

            $this->createUserRoleMapping($user->id, $user_role->id);
        }

        return $user;
    }

    public function loadUserRole(string $user_role_name)
    {
        return UserRoles::where('role_name', '=', $user_role_name)->first();
    }

    public function createUserRoleMapping($user_id, $user_role_id)
    {
        return UserRoleMapping::create([
            'user_id' => $user_id,
            'user_role_id' =>$user_role_id
        ]);
    }



}
