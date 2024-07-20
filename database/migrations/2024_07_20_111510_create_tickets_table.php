<?php

use App\Models\Destination;
use App\Models\User;
use App\Models\Vehicle;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Vehicle::class)->constrained()->cascadeOnDelete();
            $table->enum('level', ['level1', 'level2', 'level3']);
            $table->integer('number_of_passengers');
            $table->foreignIdFor(Destination::class)->constrained()->cascadeOnDelete();
            $table->decimal('price', 8, 2);
            $table->decimal('service_price', 8, 2);
            $table->boolean('sold_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
