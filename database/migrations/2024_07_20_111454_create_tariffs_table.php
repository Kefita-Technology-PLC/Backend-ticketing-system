<?php

use App\Models\Destination;
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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Station::class);
            $table->foreignIdFor(Destination::class);
            $table->integer('distance');
            $table->integer('number_of_passengers');
            $table->decimal('level1_price', 8, 2);
            $table->decimal('level2_price', 8, 2);
            $table->decimal('level3_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
