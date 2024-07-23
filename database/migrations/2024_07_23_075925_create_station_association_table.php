<?php

use App\Models\Association;
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
        Schema::create('station_association', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Station::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Association::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('station_association');
    }
};
