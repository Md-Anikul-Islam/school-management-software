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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('photo')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('status')->default(1);
            $table->text('routine')->nullable();
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
        Schema::dropIfExists('teachers');
    }
};
