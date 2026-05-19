<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('teacher_substitution_logs')) {

            Schema::create('teacher_substitution_logs', function (Blueprint $table) {
                $table->id();

                $table->foreignId('teacher_id');
                $table->foreignId('substituted_teacher_id');
                $table->foreignId('class_id');
                $table->foreignId('subject_id')->nullable();

                $table->timestamp('started_at');
                $table->timestamp('ended_at')->nullable();

                $table->decimal('total_hours', 8, 2)->nullable();

                $table->foreignId('created_by')->nullable();

                $table->string('status', 30)->default('ativa');

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_substitution_logs');
    }
};