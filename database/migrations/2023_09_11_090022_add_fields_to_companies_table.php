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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('company_email')->nullable()->after('company_industry_id');
            $table->string('company_phone')->nullable()->after('company_email');
            $table->string('company_account_id')->nullable()->after('company_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['company_email', 'company_phone', 'company_account_id']);
        });
    }
};
