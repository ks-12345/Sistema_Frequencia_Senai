<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_substitution_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('substituted_teacher_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('class_id')->constrained('turmas')->restrictOnDelete();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->decimal('total_hours', 8, 2)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 30)->default('ativa');
            $table->timestamps();

            $table->index(['teacher_id', 'status']);
            $table->index(['substituted_teacher_id', 'started_at']);
            $table->index(['class_id', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_substitution_logs');
    }
};
