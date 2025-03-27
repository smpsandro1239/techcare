<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function index()
    {
        // Pegue todos os pedidos (agendamentos)
        $orders = Order::with('agendamento', 'user')->get();

        return view('admin.order.history', compact('orders'));
    }
}

