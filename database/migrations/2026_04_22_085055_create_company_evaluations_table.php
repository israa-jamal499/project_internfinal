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
        Schema::create('company_evaluations', function (Blueprint $table) {
            $table->id();

            $table->enum('commitment_discipline', ['ممتاز', 'جيد جدا', 'جيد', 'ضعيف']);
            $table->enum('communication_teamwork', ['ممتاز', 'جيد جدا', 'جيد', 'ضعيف']);
            $table->enum('technical_skills', ['ممتاز', 'جيد جدا', 'جيد', 'ضعيف']);
            $table->text('general_feedback')->nullable();
            $table->boolean('is_final')->default(true);
            $table->enum('overall_assessment', ['1', '2', '3', '4', '5'])->nullable();

            $table->foreignId('internships_id')->constrained('internships')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_evaluations');
    }
};