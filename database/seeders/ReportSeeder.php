<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::first();
        $vendor = User::where('email', 'vendor@example.com')->first();

        Report::create([
            'order_id' => $order->id,
            'user_id' => $vendor->id,
            'content' => 'Relatório de reparo: O smartphone foi reparado com sucesso.',
        ]);
    }
}
