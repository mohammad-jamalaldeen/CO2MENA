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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('user_type_id');
            $table->string('action')->nullable();
            $table->timestamps();
            $table->index('module_id');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->index('user_type_id');
            $table->foreign('user_type_id')->references('id')->on('user_types')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
