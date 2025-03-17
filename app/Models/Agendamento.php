<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    /**
     * Definir os campos que podem ser preenchidos (mass assignable).
     * Inclui 'duracao' para suportar agendamentos com duração variável.
     *
     * @var array
     */
    protected $fillable = [
        'nome_cliente',
        'data',
        'hora',
        'servico',
        'duracao', // Adicionado para armazenar a duração em horas (ex.: 1.0, 2.0, 1.5)
    ];

    /**
     * Indica se o modelo deve usar timestamps (created_at e updated_at).
     * Por padrão, está habilitado, mas pode ser desativado se necessário.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Definir os campos que devem ser tratados como datas/caras.
     * 'data' e 'hora' serão automaticamente convertidos para instâncias Carbon.
     *
     * @var array
     */
    protected $dates = [
        'data',
        'hora',
    ];

    /**
     * Definir os atributos que devem ser convertidos para tipos nativos.
     * 'duracao' será tratado como um número decimal.
     *
     * @var array
     */
    protected $casts = [
        'duracao' => 'decimal:2', // Garante que 'duracao' seja tratado como decimal com 2 casas
    ];
}
