<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Imports explícitos para maior clareza
use App\Models\Agendamento;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    // Defina o nome da tabela (caso não siga a convenção padrão)
    protected $table = 'orders';

    // Defina os campos que podem ser preenchidos
    protected $fillable = ['agendamento_id', 'user_id', 'scheduled_at', 'status'];

    // Defina as relações
    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Defina o formato da data 'scheduled_at' para que seja tratado corretamente como uma data
    protected $dates = [
        'scheduled_at', // 'scheduled_at' será tratado como uma data
        'created_at',
        'updated_at',
    ];

    // Opcional: Adicionar casts para o campo 'status' (se for um enum ou valores fixos)
    protected $casts = [
        'status' => 'string', // Ajuste conforme necessário (ex.: 'enum' se usar um pacote como spatie/laravel-enum)
    ];
}
