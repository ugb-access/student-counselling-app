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
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('photo_path')->nullable(false);
            $table->string('full_name')->nullable(false);
            $table->string('email', 255)->unique()->nullable(false);
            $table->string('nationality', 255)->nullable(false);
            $table->integer('marital_status')->nullable(false);
            $table->integer('gender')->nullable(false);
            $table->date('date_of_birth')->nullable(false);
            $table->string('place_of_birth', 255)->nullable(false);
            $table->string('passport_no', 50)->nullable(false);
            $table->date('expiry_date')->nullable(false);
            $table->string('place_of_issue', 255)->default('');
            $table->text('address')->nullable(false);
            $table->string('phone', 35)->nullable(false);
            $table->string('mobile', 35)->nullable(false);
            $table->string('mobile_2', 35)->nullable(false);
            $table->string('referee_name')->nullable(false);
            $table->string('referee_mobile', 35)->default('');
            $table->string('document_correction', 255)->default('');
            $table->json('education_history')->nullable(false);
            $table->integer('semester_year')->nullable(false);
            $table->json('country_detail')->nullable(false);

            // pdf fields all optional
            $table->string('cv_path')->default('');
            $table->string('passport')->default('');
            $table->json('english_test');
            $table->string('academic_document')->default('');
            $table->string('teacher_reference')->default('');
            $table->string('cnic')->default('');
            $table->string('experience_letter')->default('');
            $table->string('other_certificates')->default('');
            $table->string('conditional_offer')->default('');
            $table->string('unconditional_offer')->default('');
            $table->string('payment_proof')->default('');
            $table->string('cas_ecoe')->default('');
            $table->string('visa')->default('');
            $table->string('travel_plan')->default('');
            $table->string('gt_document')->default('');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
