<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('frequencias', function (Blueprint $table) {
    $table->id();
    $table->foreignId('aluno_id')->constrained();
    $table->foreignId('lancado_por_id')->constrained('users');
    $table->foreignId('aprovado_por_id')->nullable()->constrained('users');
    $table->date('data');
    $table->enum('status_presenca', ['presente', 'falta', 'atraso']);
    $table->enum('status_aprovacao', ['aprovado', 'pendente', 'rejeitado'])->default('aprovado');
    $table->text('observacao')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequencias');
    }
};
