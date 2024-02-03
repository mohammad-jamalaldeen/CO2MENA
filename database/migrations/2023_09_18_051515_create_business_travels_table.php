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
        Schema::create('business_travels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('row_id')->nullable();
            $table->string('vehicles');
            $table->string('type');
            $table->string('fuel');
            $table->string('unit');
            $table->string('factors')->nullable();
            $table->string('total_distance')->nullable();
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
        Schema::dropIfExists('business_travels');
    }
};
