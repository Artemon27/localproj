<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('off_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->timestamp('date')->nullable();
            $table->string('prpsk')->nullable();
            $table->string('room')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('allow')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('off_hours');
    }
}
