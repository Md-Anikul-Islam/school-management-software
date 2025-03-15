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
        Schema::create('question_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_group_id')->nullable();
            $table->unsignedBigInteger('question_level_id')->nullable();
            $table->text('question')->nullable();
            $table->text('explanation')->nullable();
            $table->string('upload')->nullable(); // Store filename only
            $table->text('hints')->nullable();
            $table->integer('mark')->nullable();
            $table->string('question_type')->nullable();
            $table->text('options')->nullable(); // JSON array of options
            $table->text('correct_answers')->nullable(); // JSON array of correct answers
            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_banks');
    }
};
