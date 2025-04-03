<?php

namespace Database\Seeders;

use App\Models\Agendamento;
use Illuminate\Database\Seeder;

class AgendamentoSeeder extends Seeder
{
    public function run(): void
    {
        Agendamento::create([
            'nome_cliente' => 'João Silva',
            'data' => '2025-04-01',
            'hora' => '10:00',
            'servico' => 'Reparo de Smartphone',
            'duracao' => 2.5,
        ]);

        Agendamento::create([
            'nome_cliente' => 'Maria Oliveira',
            'data' => '2025-04-02',
            'hora' => '14:00',
            'servico' => 'Instalação de Software',
            'duracao' => 1.0,
        ]);
    }
}
