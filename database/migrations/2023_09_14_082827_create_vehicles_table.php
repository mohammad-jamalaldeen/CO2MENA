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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('row_id')->nullable();
            $table->string('vehicle_type');
            $table->string('vehicle');
            $table->string('type');
            $table->string('fuel');
            $table->string('factors')->nullable();
            $table->string('distance')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
};
