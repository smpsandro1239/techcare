<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class SellerMainController extends Controller
{
    public function index()
    {
        return view('seller.dashboard');
    }

    public function orderhistory()
    {
        return view('seller.orderhistory');
    }
}
