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
            $table->integer('guardian_id')->nullable();
            $table->date('admission_date')->nullable();
            $table->date('dob')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('blood_group_id')->nullable();
            $table->string('religion')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('optional_subject_id')->nullable();
            $table->string('reg_no')->nullable();
            $table->string('roll')->nullable();
            $table->string('photo')->nullable();
            $table->text('extra_curricular_activities')->nullable();
            $table->text('remarks')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('students');
    }
};
