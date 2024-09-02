<?php

use App\Models\Association;
use App\Models\DeploymentLine;
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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            // $table->string('station_name');
            $table->foreignIdFor(Station::class);
            $table->foreignIdFor(DeploymentLine::class);
            $table->foreignIdFor(Association::class);
            $table->string('ticket_count');
            $table->decimal('revenue');
            $table->decimal('total_sale');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
