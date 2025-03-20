<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignKeysFromOtherTables extends Migration
{
    /**
     * Execute the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Exemplo: remover a chave estrangeira de uma tabela chamada 'other_table'
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign(['stores_user_id_foreign']); // Substitua 'store_id' pelo nome real da coluna
        });
    }

    public function down()
    {
        // Caso queira reverter a remoção da chave estrangeira
        Schema::table('stores', function (Blueprint $table) {
            $table->foreign('stores_user_id_foreign')->references('id')->on('stores')->onDelete('cascade');
        });
    }
}
