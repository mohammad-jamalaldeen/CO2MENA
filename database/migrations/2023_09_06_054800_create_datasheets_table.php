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
        Schema::create('datasheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('data_assessor')->nullable();
            $table->string('uploaded_by')->nullable();
            $table->dateTime('date_time');
            $table->date('reporting_start_date');
            $table->date('reporting_end_date');
            $table->text('uploaded_file_name')->nullable();
            $table->text('calculated_file_name')->nullable();
            $table->string('source_id')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',['0','1','2','3','4','5'])->default('0')->comment('0=>Uploded, 1=>In Progress, 2=>Completed, 3=>Published, 4=>Failed, 5=>Drafted');
            $table->enum('is_draft',['0','1'])->default('0')->comment('1=>True, 0=>False');
            $table->string('uploded_sheet')->nullable();
            $table->string('emission_calculated')->nullable();
            $table->text('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasheets');
    }
};
