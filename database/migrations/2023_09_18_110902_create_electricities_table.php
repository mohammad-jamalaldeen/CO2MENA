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
        Schema::create('electricities', function (Blueprint $table) {
            $table->id();
            $table->string('row_id')->nullable();
            $table->string('electricity_type');
            $table->string('activity');
            $table->string('country')->default('971');
            $table->string('type')->nullable();
            $table->string('unit');
            $table->string('factors')->nullable();
            $table->string('amount')->nullable();
            $table->string('formula')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricities');
    }
};
