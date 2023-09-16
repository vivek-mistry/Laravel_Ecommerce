<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserRoleMapping;
use App\Models\UserRoles;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MigrateEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:environment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'In this command, action migrate defaults data : user_roles and one for admin users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * User Roles Configured
         */
        $user_role = [
            'role_name' => UserRoles::USER_ROLE_USER
        ];
        UserRoles::create($user_role);
        $user_role = [
            'role_name' => UserRoles::USER_ROLE_ADMIN
        ];
        UserRoles::create($user_role);
        echo "=== Created User Roles ===".PHP_EOL;

        /**
         * Created Administrator Credentials
         */
        $password = 12345678;
        $user_data = [
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'phone_number' => '8523658521',
            'password' => Hash::make($password),
        ];
        $user = User::create($user_data);

        /**
         * Assign the Admin Role to this user
         */
        $user_role = UserRoles::where('role_name', '=', UserRoles::USER_ROLE_ADMIN)->first();
        $user_role_mapping = [
            'user_id' => $user->id,
            'user_role_id' => $user_role->id,
        ];
        UserRoleMapping::create($user_role_mapping);
        echo "=== Created User Email (Administrator) ===".$user_data['email'].PHP_EOL;
        echo "=== Created User Password (Administrator) ===".$password.PHP_EOL;


        echo "=== END SCRIPT ===".PHP_EOL;
    }
}
