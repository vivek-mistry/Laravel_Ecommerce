<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Load Home Page View
     *
     * @return View
     */
    public function index() : View
    {
        return view('components.front-end.pages.home');
    }
}
