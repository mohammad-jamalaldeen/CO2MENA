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
        Schema::create('material_uses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('row_id')->nullable();
            $table->string('activity');
            $table->string('waste_type');
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
        Schema::dropIfExists('material_usess');
    }
};
