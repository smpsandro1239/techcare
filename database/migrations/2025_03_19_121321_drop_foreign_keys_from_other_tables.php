<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Só tentar modificar stores se ela existir
        if (Schema::hasTable('stores')) {
            Schema::table('stores', function (Blueprint $table) {
                $table->dropForeign(['stores_stores_user_id_foreign_foreign']);
            });
        }
    }

    public function down(): void
    {
        // Nada a fazer no down, já que stores não existe mais no fluxo atual
    }
};
