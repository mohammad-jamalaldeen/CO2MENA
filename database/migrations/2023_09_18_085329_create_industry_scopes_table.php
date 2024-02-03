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
        Schema::create('industry_scopes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('industry_id');
            $table->foreign('industry_id')->references('id')->on('company_industries')->onDelete('cascade');
            $table->unsignedBigInteger('scope_id');
            $table->foreign('scope_id')->references('id')->on('scopes')->onDelete('cascade');
            $table->unsignedBigInteger('activity_id');
            $table->foreign('activity_id')->references('id')->on('emission_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industry_scopes');
    }
};
