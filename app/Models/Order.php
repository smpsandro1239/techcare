<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Agendamento::class);  // A ordem pertence a um agendamento
    }

    public function user()
    {
        return $this->belongsTo(User::class);  // A ordem pertence a um usuário
    }

    // Defina o formato da data 'scheduled_at' para que seja tratado corretamente como uma data
    protected $dates = [
        'scheduled_at', // 'scheduled_at' será tratado como uma data
    ];

    // Caso você tenha outros campos de tipo data, adicione-os à lista de $dates
}
