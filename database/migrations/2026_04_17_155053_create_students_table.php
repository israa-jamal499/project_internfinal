<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->foreignId('college_id')->constrained('colleges')->cascadeOnDelete();
            $table->foreignId('specialization_id')->constrained('specializations')->cascadeOnDelete();

            $table->string('full_name', 150);
            $table->string('university_number', 45)->unique();
            $table->string('level', 45)->nullable();
            $table->enum('general_status', [
                'active',
                'training_pending',
                'training_running',
                'training_completed',
                'graduated',
                'suspended'
            ])->default('active');

            $table->string('cv')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('phone', 45)->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birthdate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};