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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->enum('status', ['قيد التدريب', 'مكتمل', 'متوقف'])->default('قيد التدريب');

            $table->integer('required_hours')->default(0);
            $table->integer('completed_hours')->default(0);
            $table->integer('total_hours')->default(0);

            $table->string('notes', 255)->nullable();
            $table->text('tasks')->nullable();

            $table->foreignId('students_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('companies_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('supervisors_id')->nullable()->constrained('supervisors')->nullOnDelete();
            $table->foreignId('opportunities_id')->constrained('opportunities')->cascadeOnDelete();
            $table->foreignId('applications_id')->constrained('applications')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
