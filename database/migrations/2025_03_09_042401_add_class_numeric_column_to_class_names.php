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
        Schema::table('class_names', function (Blueprint $table) {
            $table->integer('class_numeric')->after('name')->nullable();
            $table->integer('teacher_id')->after('class_numeric')->nullable();
            $table->text('note')->after('teacher_id')->nullable();
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_names', function (Blueprint $table) {
            $table->dropColumn('class_numeric');
            $table->dropColumn('teacher_id');
            $table->dropColumn('note');
            $table->integer('status')->after('class_numeric')->nullable();
        });
    }
};
