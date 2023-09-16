<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CartRepositoryInterface $cartRepository
    ) {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Load product listing view
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $category_id = $request->get('category_id', null);
        $search = $request->get('search', null);
        $data['product_list'] = $this->productRepository->getFilterProductByCatgoryId($category_id, 12, 0, $search)['data'];
        $data['category_id'] = $category_id;
        $data['search'] = $search;
        return view('components.front-end.pages.product-list')->with($data);
    }

    public function productJsonCall(Request $request)
    {
        $limit = $request->get('limit', null);
        $offset = $request->get('offset', null);
        $search = $request->get('search', null);
        $category_id = $request->get('category_id', null);
        $filter = $this->productFilterPrepare($request);
        $data['product_list'] = $this->productRepository->getFilterProductByCatgoryId($category_id, $limit, $offset, $search, $filter)['data'];
        $htmldata = view('components.front-end.pages.product-card')->with($data)->render();
        $results = [
            'htmldata' => $htmldata
        ];
        echo json_encode($results);
        exit;
    }

    /**
     * Load product detail view
     *
     * @return View
     */
    public function detail($product_id): View
    {
        $with = [
            'category', 'product_images'
        ];
        $data['product'] = $this->productRepository->getProductById($product_id, $with);
        $data['cart'] = [];
        
        if(isset(Auth::user()->id))
        {
            $data['cart'] = $this->cartRepository->getRowByWhere([
                'user_id' => Auth::user()->id,
                'product_id' => $product_id
            ]);
        }
        // dd($data);
        
        return view('components.front-end.pages.product-detail')->with($data);
    }

    public function productFilterPrepare($request)
    {
        $filter = [];
        if($request->get('price_filter', null))
        {
            $filter['price_filter'] = $request->get('price_filter', null);
        }
        return $filter;
    }

    public function search(Request $request)
    {
        // Log::info('search => '.$request->get());
        $limit = 8;#$request->get('limit', null)
        $offset = 0;#$request->get('offset', null)
        $search = $request->get('search', null);
        $filter = $this->productFilterPrepare($request);
        $products_list = $this->productRepository->getFilterProductByCatgoryId(null, $limit, $offset, $search, $filter)['data'];
        return response()->json($products_list, 200);
    }
}
