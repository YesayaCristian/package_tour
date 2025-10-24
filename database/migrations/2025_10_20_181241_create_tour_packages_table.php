<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('description');
            $table->string('location', 100);
            $table->string('duration', 50);
            $table->decimal('price', 12, 2);
            $table->integer('available_seats');
            $table->string('image')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['available', 'full', 'inactive'])->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_packages');
    }
};