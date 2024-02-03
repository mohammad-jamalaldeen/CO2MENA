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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('company_name')->nullable();
            $table->string('trade_licence_number')->nullable();
            $table->string('no_of_employees')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->unsignedBigInteger('company_industry_id');
            $table->foreign('company_industry_id')->references('id')->on('company_industries')->onDelete('cascade');
            $table->enum('is_draft',['0','1'])->default('1')->comment('0=>false,1=>true')->nullable();
            $table->integer('draft_step')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
