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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('origin')->after('car_type')->nullable();
            $table->string(column: 'destination')->after('origin')->nullable();
            $table->unsignedBigInteger('deployment_line_id')->nullable(true)->change();
            $table->enum('level', ['level_1', 'level_2', 'level_3','level_4','level_5'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('origin');
            $table->dropColumn('destination');
            $table->unsignedBigInteger('deployment_line_id')->nullable(false)->change();
            $table->enum('level', ['level_1', 'level_2', 'level_3'])->change();
        });
    }
};
