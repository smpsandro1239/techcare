<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agendamento_id'); // Adiciona a chave estrangeira para agendamentos
            $table->foreign('agendamento_id')->references('id')->on('agendamentos')->onDelete('cascade'); // Chave estrangeira
            $table->unsignedBigInteger('user_id'); // Exemplo de chave estrangeira para o usuário
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Chave estrangeira para usuários
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
