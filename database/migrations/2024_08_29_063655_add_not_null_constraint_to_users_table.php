<?php

use App\Models\Station;
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
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['station_id']);
            
            // Modify the column to be NOT NULL
            $table->foreignIdFor(Station::class)->nullable(false)->change();
            
            // Re-add the foreign key constraint
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the modified foreign key constraint
            $table->dropForeign(['station_id']);

            // Revert the column to be nullable
            $table->foreignIdFor(Station::class)->nullable()->change();

            // Re-add the original foreign key constraint
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
        });
    }
};
