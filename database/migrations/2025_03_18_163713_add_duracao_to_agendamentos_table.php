<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDuracaoToAgendamentosTable extends Migration
{
    public function up()
{
    Schema::table('agendamentos', function (Blueprint $table) {
        if (!Schema::hasColumn('agendamentos', 'duracao')) {
            $table->decimal('duracao', 5, 2)->nullable()->after('servico');
        }
    });
}
    public function down()
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->dropColumn('duracao');
        });
    }
}
