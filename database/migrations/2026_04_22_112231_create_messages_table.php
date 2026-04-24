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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->string('subject', 150)->nullable();
            $table->text('body');

            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            $table->boolean('is_saved')->default(false);

            $table->foreignId('internships_id')->nullable()->constrained('internships')->nullOnDelete();

            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

     public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
