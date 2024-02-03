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
        Schema::create('fuels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('row_id')->nullable();
            $table->string('type');
            $table->string('fuel')->nullable();
            $table->string('unit');
            $table->string('factor')->nullable();
            $table->string('amount')->nullable();
            $table->string('formula')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuels');
    }
};
