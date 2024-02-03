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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_type_id');
            $table->string('name')->nullable();
            $table->string('username');
            $table->string('email');
            $table->enum('email_verify',['0','1'])->default('1')->comment('1=>Yes, 0=>No');
            $table->string('profile_picture')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('otp')->nullable();
            $table->dateTime('sent_otp_datetime')->nullable();
            $table->string('forgot_password_string')->nullable();
            $table->string('password');
            $table->enum('status',['0','1'])->default('1')->comment('1=>Active, 0=>Inactive');
            $table->rememberToken();
            $table->timestamps();
            $table->index('user_type_id');
            $table->foreign('user_type_id')->references('id')->on('user_types')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
