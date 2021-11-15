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
            $table->string('odd')->nullable();
            $table->string('even')->nullable();
            $table->string('odd_holi')->nullable();
            $table->string('even_holi')->nullable();
            $table->string('odd_color')->nullable();
            $table->string('even_color')->nullable();
            $table->string('odd_holi_color')->nullable();
            $table->string('even_holi_color')->nullable();
            $table->string('base_color')->nullable();
            $table->string('background')->nullable();
            $table->string('chosen_color')->nullable();
            $table->string('chosen_dop_color')->nullable();
            $table->string('card_header')->nullable();         
            $table->string('carousel_controls')->nullable();
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
