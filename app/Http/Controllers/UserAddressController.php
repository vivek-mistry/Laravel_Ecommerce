<?php

namespace App\Http\Controllers;

use App\Events\CheckoutProcessed;
use App\Http\Requests\UserAddressStoreRequest;
use App\Models\UserAddress;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\UserAddressRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UserAddressController extends Controller
{

    /**
     * @var UserAddressRepositoryInterface
     */
    protected $userAddressRepository;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    public function __construct(
        UserAddressRepositoryInterface $userAddressRepository,
        CartRepositoryInterface $cartRepository
    )
    {
        $this->userAddressRepository = $userAddressRepository;
        $this->cartRepository = $cartRepository;
    }

    /**
     * User Address store
     *
     * @param UserAddressStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserAddressStoreRequest $request) : RedirectResponse
    {
        $user_id = Auth::user()->id;
        $request_all = $request->validated();

        $request_all['user_id'] = $user_id;
        $request_all['is_default'] = 1;
        
        $user_address = $this->userAddressRepository->createOrUpdate($request_all);

        /**
         * NOTE : One record can be active at a time
         */
        if($request_all['is_default'] = 1)
        {
            $this->userAddressRepository->oneAddressCanActive($user_id, $user_address->id);
        }
        
        // Session::flash('message_success', 'Successfully added address.');

        // return redirect('my-orders');
        return Redirect::back();
    }

    /**
     * For edit user address
     *
     * @param [type] $id
     * @return JsonResponse
     */
    public function edit($id) : JsonResponse
    {
        $user_address = $this->userAddressRepository->getById($id);
        return response()->json($user_address, 200);
    }


    /**
     * Redirect to current page
     *
     * @param [type] $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, Request $request) : RedirectResponse
    {
        // $request_all = $request->all();
        $request_data = $request->except('_token', '_method');

        if(isset($request_data['is_default']) && $request_data['is_default'])
        {
            $request_data['is_default'] = 1;
        }
        $user_address = $this->userAddressRepository->createOrUpdate($request_data, $id);

        if(isset($request_data['is_default']) && $request_data['is_default'])
        {
            $this->userAddressRepository->oneAddressCanActive($user_address->user_id, $user_address->id);
        }
        

        return Redirect::back();
    }

    /**
     * Load Addres Book View
     *
     * @return View
     */
    public function addressBook() : View
    {
        $user = Auth::user();
        $data['user_addresses'] = $this->userAddressRepository->getUserAllAddress($user->id, true);
        $data['user_default_address'] = $this->userAddressRepository->getDefaultAddress($user->id);
        return view('components.front-end.pages.address-book')->with($data);
    }
}
