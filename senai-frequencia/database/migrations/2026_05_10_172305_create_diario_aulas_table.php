<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diario_aulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turma_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professor_id')->constrained('users');
            $table->date('data');
            $table->string('titulo');
            $table->text('conteudo');
            $table->integer('aula_numero')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diario_aulas');
    }
};