<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('student_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('status')->default('em_analise');
            // em_analise | aprovado | recusado

            $table->timestamps();

            // 🚫 impede candidatura duplicada
            $table->unique(['job_id', 'student_id']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
