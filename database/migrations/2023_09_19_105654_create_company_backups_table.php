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
        Schema::create('company_backups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('file')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status',['0','1','2','3'])->default('0')->comment('0=>pending, 1=>in progress, 2=>completed, 3=>fail');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_backups');
    }
};
