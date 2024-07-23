<?php

use App\Models\Tariff;
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
        Schema::create('deployment_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tariff::class)->constrained();
            $table->string('origin');
            $table->string('destination');
            $table->enum('arrival',['pending','arrived']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deployment_lines');
    }
};
