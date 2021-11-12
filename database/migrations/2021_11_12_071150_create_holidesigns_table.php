<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidesigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->onDelete('cascade');
            $table->string('odd');
            $table->string('even');
            $table->string('odd-holi');
            $table->string('even-holi');
            $table->string('odd-color');
            $table->string('even-color');
            $table->string('odd-holi-color');
            $table->string('even-holi-color');
            $table->string('base-color');
            $table->string('background');
            $table->string('chosen-color');
            $table->string('chosen-dop-color');
            $table->string('card-header');            
            $table->string('carousel-controls');
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
        Schema::dropIfExists('holidesigns');
    }
}
