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
        Schema::table('stations', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('location'); // Replace 'some_column' with the column after which you want to add 'created_by'
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');

            // Add foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            // Drop the created_by and updated_by columns
            $table->dropColumn(['created_by', 'updated_by']);
        });
    }
};
