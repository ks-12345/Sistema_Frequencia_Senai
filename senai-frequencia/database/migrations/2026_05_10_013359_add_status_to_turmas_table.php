<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            $table->enum('status', ['ativa', 'finalizada'])->default('ativa')->after('professor_id');
            $table->timestamp('finalizada_em')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            $table->dropColumn(['status', 'finalizada_em']);
        });
    }
};