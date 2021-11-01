<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->timestamp('datefrom')->nullable();
            $table->timestamp('dateto')->nullable();
            $table->integer('days');           
            $table->integer('PVT');      
            $table->integer('INV');      
            $table->integer('OB');      
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
        Schema::dropIfExists('holidays');
    }
}
