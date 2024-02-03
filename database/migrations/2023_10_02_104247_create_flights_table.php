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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('row_id')->nullable();
            $table->string('origin');
            $table->string('destination');
            $table->string('class');
            $table->string('single_way_and_return');
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
        Schema::dropIfExists('flights');
    }
};
