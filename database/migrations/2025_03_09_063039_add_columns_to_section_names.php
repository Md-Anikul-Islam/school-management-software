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
        Schema::table('section_names', function (Blueprint $table) {
            $table->integer('capacity')->nullable()->after('name');
            $table->integer('class_id')->nullable()->after('capacity');
            $table->integer('teacher_id')->nullable()->after('class_id');
            $table->text('note')->nullable()->after('teacher_id');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_names', function (Blueprint $table) {
            $table->dropColumn('capacity');
            $table->dropColumn('class_id');
            $table->dropColumn('teacher_id');
            $table->dropColumn('note');
        });
    }
};
