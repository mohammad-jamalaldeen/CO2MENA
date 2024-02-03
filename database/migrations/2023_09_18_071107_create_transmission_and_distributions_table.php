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
        Schema::create('transmission_and_distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('row_id')->nullable();
            $table->string('activity');
            $table->string('unit');
            $table->string('factors')->nullable();
            $table->string('amount')->nullable();
            $table->string('formula')->nullable();
            $table->string('country')->default('971');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transmission_and_distributions');
    }
};
