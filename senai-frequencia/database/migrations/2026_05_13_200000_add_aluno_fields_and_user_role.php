<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('cpf')->nullable()->unique()->after('matricula');
            $table->string('email')->nullable()->unique()->after('cpf');
            $table->date('data_nascimento')->nullable()->after('email');
            $table->text('endereco')->nullable()->after('data_nascimento');
            $table->foreignId('user_id')->nullable()->constrained()->after('empresa_id');
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin','professor','empresa','secretaria','aluno') NOT NULL DEFAULT 'professor'");
        }
    }

    public function down(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'endereco', 'data_nascimento', 'email', 'cpf']);
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin','professor','empresa') NOT NULL DEFAULT 'professor'");
        }
    }
};
