<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function index()
    {
        return view('components.front-end.pages.paypal-checkout');
    }
}
