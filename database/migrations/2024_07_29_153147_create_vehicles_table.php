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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Station::class)->constrained();
            $table->foreignIdFor(Association::class)->constrained();
            $table->string('plate_number');
            $table->enum('code',['1', '2', '3']);
            $table->enum('level', ['level_1', 'level_2', 'level_3']);
            $table->integer('number_of_passengers');
            $table->string('car_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
