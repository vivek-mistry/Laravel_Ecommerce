<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use Barryvdh\Snappy\Facades\SnappyPdf;
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
    )
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Load Order view
     *
     * @return View
     */
    public function myOrders() : View
    {
        $data['orders'] = $this->orderRepository->getUserOrders(auth()->user()->id, ['current_order_status']);
        
        return view('components.front-end.pages.my-orders')->with($data);      
    }

    /**
     * Get Order By Id
     *
     * @param [type] $order_id
     * @return JsonResponse
     */
    public function getOrderById($order_id) : JsonResponse
    {
        $data['order'] = $this->orderRepository->getOrderById($order_id);
        
        $html = view('components.front-end.pages.order-list-for-model')->with($data)->render();

        return response()->json(['html' => $html, 'order' => $data['order']], 200);
    }

    public function orderInvoice($order_id)
    {
        $data['order'] = $this->orderRepository->getOrderById($order_id);
        $html = view('components.pdf.order-invoice')->with($data)->render();
        return SnappyPdf::setPaper('a4')
                ->setOption('margin-top', 20)
                ->setOrientation('portrait')
                ->setOption('margin-bottom', 0)
                // ->setOption('header-html', '<header><p>Header Header  </p></header>')
                // ->setOption('footer-html', '<footer>footer footer footer footer footer footer footer footer footer footer footer footer footer footer footer </footer>')
                ->loadHTML($html)
                // $pdf->loadView('Modulos.Funcional.OrdemServico.Os.imprime', $parametros);
                ->inline('myfile.pdf');
        
        // return view('components.pdf.order-invoice')->with($data); 
    }
}
