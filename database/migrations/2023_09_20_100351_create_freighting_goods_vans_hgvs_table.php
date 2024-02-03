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
        Schema::create('freighting_goods_vans_hgvs', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('row_id')->nullable();
            $table->string('vehicle');
            $table->string('type');
            $table->string('fuel');
            $table->string('factors')->nullable();
            $table->string('formula')->nullable();
            $table->string('distance')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freighting_goods_vans_hgvs');
    }
};
