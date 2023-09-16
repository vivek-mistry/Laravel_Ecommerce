<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataTableRS;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function index() : View
    {
        return view('components.backend.pages.order-list');
    }

    public function getAllOrders(Request $request) : JsonResponse
    {
        $with = ['current_order_status'];
        $result = $this->orderRepository->getAllOrder($with, $request->start, $request->rowperpage, $request->columnName, $request->columnSortOrder, $request->searchValue);
        $result['draw'] = $request->draw;
        return response()->json(new DataTableRS($result));
    }   
}
