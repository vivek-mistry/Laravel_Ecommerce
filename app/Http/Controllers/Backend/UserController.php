<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\DataTableRS;
use App\Models\UserRoles;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\RegisterService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * @var RegisterService
     */
    protected $registerService;

    public function __construct(
        RegisterService $registerService
    ) {
        $this->registerService = $registerService;
    }

    /**
     * Create list view
     *
     * @return View
     */
    public function index(): View
    {
        return view('components.backend.pages.user_list');
    }

    /**
     * Create Load view
     *
     * @return View
     */
    public function createLoadView(): View
    {
        return view('components.backend.pages.user_create');
    }

    /**
     * User Store Code
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $request_data = $request->validated();

        DB::beginTransaction();
        $this->registerService->createUser($request, UserRoles::USER_ROLE_USER);
        DB::commit();

        Session::flash('message_success', 'User has been created');

        return redirect('backend/user/create');
    }

    /**
     * Get All Users
     *
     * @return JsonResponse
     */
    public function getAllUsers(Request $request) : JsonResponse
    {
        $user_roles = [
            UserRoles::USER_ROLE_USER
        ];
        $result = $this->registerService->userRepository->getAllUser([], $request->start, $request->rowperpage, $request->columnName, $request->columnSortOrder, $request->searchValue, $user_roles);
        $result['draw'] = $request->draw;
        return response()->json(new DataTableRS($result));
    }

    /**
     * Edit User
     *
     * @param [type] $id
     * @return View
     */
    public function edit($id) : View
    {
        $data['user'] = $this->registerService->userRepository->getById($id);
        return view('components.backend.pages.user_edit')->with($data);
    }

    /**
     * Update User Code
     *
     * @param UserUpdateRequest $request
     * @param [type] $id
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, $id) : RedirectResponse
    {
        $request_data = $request->validated();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number
        ];
        if(isset($request->password))
        {
            $data['password'] = Hash::make($request->password);
        }

        $this->registerService->userRepository->createOrUpdate($data, $id);
        Session::flash('message_success', 'User has been updated');

        return redirect('backend/user/edit/'.$id);
    }

    public function remove($id) : RedirectResponse
    {
        Session::flash('message_success', 'User removed');
        return redirect('backend/user/list');
    }
}
