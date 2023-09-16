<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(ProductDataTable $dataTable){
        
        return $dataTable->render('components.backend.pages.product_list');
    }
}
