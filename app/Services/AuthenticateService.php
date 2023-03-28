<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticateService
{

    /**
     * Make Authentication
     *
     * @param array $authenticate_data
     * @param string $user_role_name
     * @return mixed
     */
    public function verifyAuthentication(array $authenticate_data, string $user_role_name): mixed
    {
        if($user_role_name === UserRoles::USER_ROLE_ADMIN)
        {
            $user = $auth = User::where('email', '=', $authenticate_data['email'])->first();
        }else{
            $auth = Auth::attempt($authenticate_data);
            $user = Auth::user();
        }

        if($auth)
        {
            $user->load('user_roles');
            if ($user_role_name === UserRoles::USER_ROLE_ADMIN && $user->user_roles->pluck( 'role_name' )->contains( UserRoles::USER_ROLE_ADMIN )) {
                $auth = Auth::guard('ecommerce_admin')->attempt($authenticate_data);
                if($auth){
                    return true;
                }
                
            }
            if ($user_role_name === UserRoles::USER_ROLE_USER && $user->user_roles->pluck( 'role_name' )->contains( UserRoles::USER_ROLE_USER )) {
                return true;
            }
        }
        return false;
    }

}
