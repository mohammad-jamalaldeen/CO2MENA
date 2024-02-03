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
        Schema::table('company_addresses', function (Blueprint $table) {
            // Drop the old 'country' column
            $table->dropColumn('country');

            // Add the new 'country_id' column with a foreign key constraint
            $table->unsignedBigInteger('country_id')->after('city')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_addresses', function (Blueprint $table) {
            // Reverse the changes in the 'up' method
            $table->string('country');
            $table->dropForeign(['country_id']);  // Drop the foreign key constraint
            $table->dropColumn('country_id');
        });
    }
};
