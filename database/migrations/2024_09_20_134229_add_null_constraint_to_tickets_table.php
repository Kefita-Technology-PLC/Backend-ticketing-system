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
        Schema::table('tickets', function (Blueprint $table) {
            $table->date('arrival_time')->nullable(true)->change();
            $table->date(column: 'destination_id')->nullable(true)->change();
            $table->date(column: 'deployment_line_id')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->date('arrival_time')->nullable(false)->change();
            $table->date(column: 'destination_id')->nullable(false)->change();
            $table->date(column: 'deployment_line_id')->nullable(false)->change();
        });
    }
};
