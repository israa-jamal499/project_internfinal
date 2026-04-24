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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();

            $table->integer('week_number');
            $table->text('supervisor_feedback')->nullable();

            $table->enum('status', ['قيد المراجعة', 'تمت المراجعة', 'مرفوض'])
                  ->default('قيد المراجعة');

            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->integer('hours_worked')->default(0);
            $table->text('learnings')->nullable();
            $table->text('challenges')->nullable();
            $table->text('tasks_planned')->nullable();
            $table->text('tasks_completed')->nullable();

            $table->date('week_start')->nullable();
            $table->date('week_end')->nullable();

            $table->string('file_path', 255)->nullable();

            $table->foreignId('internships_id')->constrained('internships')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};