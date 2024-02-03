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
        Schema::table('datasheets', function (Blueprint $table) {
            $table->unsignedBigInteger('last_action_by_id')->after('last_action_by')->nullable();  
            $table->unsignedBigInteger('uploaded_by_id')->after('uploaded_by')->nullable();  
            $table->index('last_action_by_id');
            $table->index('uploaded_by_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datasheets', function (Blueprint $table) {
            $table->dropColumn('last_action_by_id');
            $table->dropColumn('uploaded_by_id');
        });
    }
};
