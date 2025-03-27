<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Agendamento;
use App\Models\User; 

class AdminMainController extends Controller
{
   public function index(){
    return view('admin.admin');
   }
   public function setting(){
      return view('admin.settings');
     }
     public function manage_user(){
      return view('admin.manage.user');
     }
     public function manage_stores(){
      return view('admin.manage.store');
     }
     public function cart_history(){
      return view('admin.cart.history');
     }
     public function order_history()
{
    $orders = Order::with('user')->orderBy('scheduled_at', 'desc')->get();
    return view('admin.order.history', compact('orders'));
}

public function show($id)
{
    // Busque o pedido com o ID
    $order = Order::with('user')->findOrFail($id);

    // Retorne a view com os dados do pedido
    return view('admin.order.show', compact('order'));
}

}
