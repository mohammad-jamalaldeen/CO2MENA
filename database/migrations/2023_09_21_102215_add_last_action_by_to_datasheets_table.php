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
            $table->string('last_action_by')->after('uploaded_by')->nullable();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datasheets', function (Blueprint $table) {
            $table->dropColumn('last_action_by');
        });
    }
};
