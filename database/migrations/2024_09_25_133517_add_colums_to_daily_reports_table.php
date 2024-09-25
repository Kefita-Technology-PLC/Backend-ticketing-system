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
        Schema::table('daily_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('deployment_line_id')->nullable(true)->change();
            $table->unsignedBigInteger('station')->nullable(true)->change();
            $table->unsignedBigInteger('association')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('deployment_line_id')->nullable(false)->change();
            $table->unsignedBigInteger('station')->nullable(false)->change();
            $table->unsignedBigInteger('association')->nullable(false)->change();
        });
    }
};
