<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     *
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $data['total_user'] = $this->userRepository->getTotalUsers();
        $data['total_orders'] = $this->orderRepository->getTotalOrder();
        return view('components.backend.pages.dashboard')->with($data);
    }
}
