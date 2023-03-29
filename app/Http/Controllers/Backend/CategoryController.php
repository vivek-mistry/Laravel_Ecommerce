<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\DataTables\CategoryDataTable;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoryDataTable $dataTable){
        
        return $dataTable->render('components.backend.pages.category_list');
    }
}
