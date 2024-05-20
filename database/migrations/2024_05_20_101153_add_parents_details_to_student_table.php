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
        Schema::table('student', function (Blueprint $table) {
            $table->string('father_name')->nullable(); 
            $table->string('father_number')->nullable();
            $table->string('mother_name')->nullable(); 
            $table->string('mother_number')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
            $table->dropColumn('father_name');
            $table->dropColumn('father_number');
            $table->dropColumn('mother_name');
            $table->dropColumn('mother_number');
        });
    }
};
