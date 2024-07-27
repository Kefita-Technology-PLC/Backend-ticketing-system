<?php

use App\Models\DeploymentLine;
use App\Models\Destination;
use App\Models\Station;
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
            $table->foreignIdFor(User::class)->constrained('users');
            $table->foreignIdFor(Vehicle::class)->constrained();
            $table->foreignIdFor(Station::class);
            $table->foreignIdFor(DeploymentLine::class);
            $table->enum('level', ['level1', 'level2', 'level3']);
            $table->integer('number_of_passengers');
            $table->foreignIdFor(Destination::class)->constrained();
            $table->decimal('price', 8, 2);
            $table->decimal('service_price', 8, 2);
            $table->boolean('sold_status')->nullable();
            $table->date('arrival_time');
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
