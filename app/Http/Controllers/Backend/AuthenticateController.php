<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\UserRoles;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\AuthenticateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticateController extends Controller
{
    /**
     * @var AuthenticateService
     */
    protected $authenticateService;

    /**
     *
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    public function __construct(
        AuthenticateService $authenticateService,
        UserRepositoryInterface $userRepository
    ) {
        $this->authenticateService = $authenticateService;
        $this->userRepository = $userRepository;
    }

    /**
     * Load authenticate page
     *
     * @return void
     */
    public function loadSignin()
    {
        $admin_auth = Auth::guard('ecommerce_admin')->user();
        if ($admin_auth) {
            return redirect('backend/user/list');
        }
        return view('components.backend.pages.login');
    }

    public function checkAuthenticate(AuthRequest $request)
    {
        $request_data = $request->validated();
        $is_bool_user = $this->authenticateService->verifyAuthentication($request_data, UserRoles::USER_ROLE_ADMIN);
        if ($is_bool_user) {
            return redirect('backend/user/list');
        } else {
            Session::flash('message_error', 'Unauthenticate User.');
            return redirect('backend');
        }
    }

    /**
     * Change Profile
     *
     * @return View
     */
    public function changeProfile() : View
    {
        $data['user'] = Auth::guard('ecommerce_admin')->user();
        return view('components.backend.pages.change-profile')->with($data);
    }

    /**
     * Update Profile
     *
     * @param UserUpdateRequest $request
     * @param [type] $id
     * @return RedirectResponse
     */
    public function updateProfile(UserUpdateRequest $request, $id): RedirectResponse
    {
        $request_data = $request->validated();
        $admin_auth = Auth::guard('ecommerce_admin')->user();
        $admin_auth->name = $request->name;
        $admin_auth->email = $request->email;
        $admin_auth->phone_number = $request->phone_number;
        if(isset($request->password))
        {
            $admin_auth->password = Hash::make($request->password);
        }
        $admin_auth->save();
        Session::flash('message_success', 'Profile has been updated');

        return redirect('backend/change-profile');
    }

    /**
     * Sign out
     *
     * @return RedirectResponse
     */
    public function signOut(): RedirectResponse
    {
        Auth::guard('ecommerce_admin')->logout();
        return redirect('backend');
    }
}
