<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\CommonMailSend;
use App\Models\User;
use App\Models\UserRoles;
use App\Repositories\Interfaces\UserAddressRepositoryInterface;
use App\Services\AuthenticateService;
use App\Services\RegisterService;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * @var RegisterService
     */
    protected $registerService;

    protected $userRepository;

    /**
     * @var UserAddressRepositoryInterface 
     */
    protected $userAddressRepository;

    /**
     * @var AuthenticateService
     */
    protected $authenticateService;

    public function __construct(
        RegisterService $registerService,
        AuthenticateService $authenticateService,
        UserAddressRepositoryInterface $userAddressRepository
    ) {
        $this->registerService = $registerService;
        $this->userRepository = $registerService->userRepository;
        $this->authenticateService = $authenticateService;
        $this->userAddressRepository = $userAddressRepository;
    }



    /**
     * Load sign in view
     *
     * @return void
     */
    public function signIn()
    {
        $auth = Auth::user();
        if ($auth) {
            return redirect('home');
        }
        return view('components.front-end.pages.sign-in');
    }

    /**
     * Load Register view
     *
     * @return void
     */
    public function registerView()
    {
        $auth = Auth::user();
        if ($auth) {
            return redirect('home');
        }
        return view('components.front-end.pages.register');
    }

    /**
     * Check user Authentication
     *
     * @param AuthRequest $request
     * @return RedirectResponse
     */
    public function authenticate(AuthRequest $request): RedirectResponse
    {
        $request_data = $request->validated();
        $is_bool_user = $this->authenticateService->verifyAuthentication($request_data, UserRoles::USER_ROLE_USER);
        if ($is_bool_user) {
            return redirect('home');
        } else {
            Session::flash('message_error', 'Unauthenticate User.');
            return redirect('sign-in');
        }
    }

    /**
     * Store user (register user)
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $request_data = $request->validated();
        DB::beginTransaction();
        $user = $this->registerService->createUser($request, UserRoles::USER_ROLE_USER);
        DB::commit();

        /**
         * Mail send to user
         */
        Mail::to($user->email)->send(new CommonMailSend($user, 'welcome_user_mail'));

        Session::flash('message_success', 'Successfully registered.');
        return redirect('register');
    }

    public function mailTest()
    {
        $user = User::find(7);
        $v  = Mail::to($user->email)->send(new CommonMailSend($user, 'welcome_user_mail'));
    }

    /**
     * Sign out web user and redirect them to new
     *
     * @return RedirectResponse
     */
    public function signOut(): RedirectResponse
    {
        Auth::guard('web')->logout();
        return redirect('home');
    }

    /**
     * Check Authentication of user
     *
     * @return JsonResponse
     */
    public function checkAuthUser(): JsonResponse
    {
        $auth = Auth::user();
        if ($auth) {
            return response()->json(['is_login' => true], 200);
        }
        return response()->json(['is_login' => false], 200);
    }

    /**
     * Load my account view
     *
     * @return View
     */
    public function myAccount(): View
    {
        $data['user'] = Auth::user();
        $data['user_default_address'] = $this->userAddressRepository->getDefaultAddress($data['user']->id);
        return view('components.front-end.pages.my-account')->with($data);
    }

    /**
     * Account info load view
     *
     * @return View
     */
    public function accountInfo(): View
    {
        $data['user'] = Auth::guard('web')->user();
        return view('components.front-end.pages.account-info')->with($data);
    }

    public function updateAccountInfo(UserUpdateRequest $request, $user_id)
    {
        $request_data = $request->validated();
        $user = Auth::guard('web')->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        $user->save();
        Session::flash('message_success', 'Profile has been updated');
        return redirect('account-info');
    }

    /**
     * Change Password
     *
     * @return View
     */
    public function changePassword(): View
    {
        return view('components.front-end.pages.change-password');
    }

    /**
     * Update Password & redirect signout
     *
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     */
    public function updatePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $request->validated();

        $data = [
            'password' => Hash::make($request->new_password)
        ];
        $user = auth()->user();

        /**
         * Mail send to user
         */
        Mail::to($user->email)->send(new CommonMailSend($user, 'change_user_password_mail'));

        $this->userRepository->createOrUpdate($data, $user->id);
        return redirect('sign-out');
    }

    public function forgetPasswordView(): View
    {
        return view('components.front-end.pages.forget-password');
    }

    public function demoPdf()
    {
        return view('components.pdf.order-invoice');   
        /*$html = '<h1>Bill</h1><p>You owe me money, dude.</p>';
        
        return SnappyPdf::setPaper('a4')
                ->setOption('margin-top', 20)
                ->setOrientation('portrait')
                ->setOption('margin-bottom', 0)
                ->setOption('header-html', '<header><p>Header Header  </p></header>')
                ->setOption('footer-html', '<footer>footer footer footer footer footer footer footer footer footer footer footer footer footer footer footer </footer>')
                ->loadHTML($html)
                // $pdf->loadView('Modulos.Funcional.OrdemServico.Os.imprime', $parametros);
                ->download('myfile.pdf');*/
    }

    public function invoiceDesign()
    {
        return view('components.pdf.order-invoice');   
    }
}
