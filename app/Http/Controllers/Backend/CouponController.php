<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Http\Resources\DataTableRS;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CouponController extends Controller
{

    /**
     * @var CouponRepositoryInterface
     */
    protected $couponRepository;
    
    /**
     * @param CouponRepositoryInterface $couponRepository
     */
    public function __construct(
        CouponRepositoryInterface $couponRepository
    )
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * Load coupon list
     *
     * @return View
     */
    public function index() : View
    {
        return view('components.backend.pages.coupon_list');
    }

    /**
     * Create Load view
     *
     * @return View
     */
    public function createLoadView() : View
    {
        return view('components.backend.pages.coupon_create');
    }

    /**
     * Paginate Coupon
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAll(Request $request) : JsonResponse
    {
        $result = $this->couponRepository->getAll([], $request->start, $request->rowperpage, $request->columnName, $request->columnSortOrder, $request->searchValue);
        $result['draw'] = $request->draw;
        return response()->json(new DataTableRS($result), 200);
    }

    /**
     * Store and redirect
     *
     * @param CouponStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CouponStoreRequest $request) : RedirectResponse
    {
        $request_data = $request->validated();

        DB::beginTransaction();
        $request_data['is_active'] = isset($request_data['is_active']) ? $request_data['is_active'] : 0; 
        $this->couponRepository->createOrUpdate($request_data);
        DB::commit();

        Session::flash('message_success', 'Coupon has been created');

        return redirect('backend/coupon/create');
    }

    public function remove($id) : RedirectResponse
    {
        Session::flash('message_success', 'Coupon removed');
        $this->couponRepository->remove($id);
        return redirect('backend/coupon/list');
    }

    public function edit($id)
    {
        $data['coupon'] = $this->couponRepository->getById($id);

        return view('components.backend.pages.coupon_edit')->with($data);
    }

    /**
     * Update coupon
     *
     * @param [type] $id
     * @param CouponUpdateRequest $request
     * @return RedirectResponse
     */
    public function update($id, CouponUpdateRequest $request) : RedirectResponse
    {
        $request_data = $request->validated();

        DB::beginTransaction();
        $request_data['is_active'] = isset($request_data['is_active']) ? $request_data['is_active'] : 0; 
        $this->couponRepository->createOrUpdate($request_data, $id);
        DB::commit();

        Session::flash('message_success', 'Coupon has been updated');

        return redirect('backend/coupon/edit/'.$id);
    }
}
