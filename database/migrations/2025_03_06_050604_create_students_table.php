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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedInteger('guardian_id')->nullable();
            $table->date('admission_date')->nullable();
            $table->date('dob')->nullable();
            $table->unsignedInteger('gender')->nullable();
            $table->string('blood_group_id')->nullable();
            $table->string('religion')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Bangladesh');
            $table->unsignedInteger('class_id')->nullable();
            $table->unsignedInteger('section_id')->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->unsignedInteger('optional_subject_id')->nullable();
            $table->string('reg_no')->nullable();
            $table->string('roll')->nullable();
            $table->string('photo')->nullable();
            $table->text('extra_curricular_activities')->nullable();
            $table->text('remarks')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedInteger('school_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
