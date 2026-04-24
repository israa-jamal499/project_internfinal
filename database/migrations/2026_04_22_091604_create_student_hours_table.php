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
        Schema::create('student_hours', function (Blueprint $table) {
            $table->id();

            $table->date('work_date');
            $table->integer('hours');
            $table->text('description');

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('supervisor_feedback')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->foreignId('internships_id')->constrained('internships')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_hours');
    }
};