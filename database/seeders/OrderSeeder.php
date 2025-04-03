<?php

namespace Database\Seeders;

use App\Models\Agendamento;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $agendamento = Agendamento::where('nome_cliente', 'João Silva')->first();
        $customer = User::where('email', 'customer@example.com')->first();
        $vendor = User::where('email', 'vendor@example.com')->first();

        Order::create([
            'agendamento_id' => $agendamento->id,
            'user_id' => $customer->id,
            'scheduled_at' => now()->addDays(1),
            'seller_id' => $vendor->id,
        ]);
    }
}
