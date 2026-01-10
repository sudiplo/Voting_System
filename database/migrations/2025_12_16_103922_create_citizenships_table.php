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
        Schema::create('citizenships', function (Blueprint $table) {
            $table->id();
            $table->string('name_nepali');
            $table->string('name_english');
            $table->string('citizenship_number')->unique();
            $table->string('father');
            $table->string('mother');
            $table->date('dob');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->enum('type', ['वंशज', 'अंगीकृत', 'गैर आवासीय','सम्मानार्थ']);
            $table->foreignId("district_id")->constrained();
            $table->foreignId("palika_id")->constrained();
            $table->foreignId("ward_id")->constrained();
            $table->string('partner')->nullable();
            $table->longText('photo');
            $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizenships');
    }
};
