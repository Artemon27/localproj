<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsinRoomPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('room_persons', function (Blueprint $table) {
      $table->string('name_staff')->nullable();
      $table->string('name_post')->nullable();
      $table->string('pager')->nullable();
      $table->string('pechat')->nullable();
      $table->string('mobile')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('room_persons', function (Blueprint $table) {
      $table->string('name_staff')->nullable();
      $table->string('name_post')->nullable();
      $table->string('pager')->nullable();
      $table->string('pechat')->nullable();
      $table->string('mobile')->nullable();
    });
    }
}
