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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id')->nullable();
            $table->integer('teacher_id')->nullable();
            $table->string('type')->nullable();
            $table->integer('pass_mark')->nullable();
            $table->integer('final_mark')->nullable();
            $table->string('subject_author')->nullable();
            $table->string('name');
            $table->string('subject_code')->nullable();
            $table->string('status')->default(1);
            $table->integer('school_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
