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
        Schema::create('customer_support_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_support_id');
            $table->string('file_name')->nullable();
            $table->foreign('customer_support_id')->references('id')->on('customer_supports')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_support_files');
    }
};
