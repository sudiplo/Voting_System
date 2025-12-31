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
        Schema::create('ward_candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_id')->constrained();
            $table->foreignId('district_id')->constrained();
            $table->foreignId('palika_id')->constrained();
            $table->foreignId('ward_id')->constrained();
            $table->foreignId('election_id')->constrained();
            $table->enum('post', ['Ward Chairperson', 'Ward Member','Ward Member(Women)','Ward Member(Dalit)']);
            $table->text('party');
            $table->longText('goal');
            $table->text('vote')->nullable();
            $table->text('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ward_candidates');
    }
};
