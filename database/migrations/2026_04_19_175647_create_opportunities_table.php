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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('description');
            $table->enum('type', ['حضوري', 'عن بعد', 'هجين']);
            $table->integer('required_hours');
            $table->integer('seats');
            $table->integer('filled_seats')->default(0);
            $table->date('deadline');
            $table->enum('status', ['مفتوحة', 'مغلقة', 'مسودة'])->default('مفتوحة');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->foreignId('cities_id')->constrained('cities')->cascadeOnDelete();
            $table->foreignId('companies_id')->constrained('companies')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
