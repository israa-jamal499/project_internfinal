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
        Schema::create('supervisors_evaluations', function (Blueprint $table) {
            $table->id();

            $table->enum('overall_assessment', ['ممتاز', 'جيد جدًا', 'جيد', 'مقبول']);
            $table->integer('commitment');
            $table->integer('skills');
            $table->integer('communication');

            $table->text('general_feedback')->nullable();
            $table->boolean('is_final')->default(true);

            $table->foreignId('internships_id')->constrained('internships')->cascadeOnDelete();
             $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supervisors_evaluations');
    }
};
