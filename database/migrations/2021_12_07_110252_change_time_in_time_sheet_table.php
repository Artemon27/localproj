<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTimeInTimeSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement('ALTER TABLE time_sheets MODIFY COLUMN time FLOAT');
        /*Schema::table('time_sheets', function (Blueprint $table) {
            $table->float('time')->change();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      DB::statement('ALTER TABLE time_sheets MODIFY COLUMN time INT');
        /*Schema::table('time_sheets', function (Blueprint $table) {
          $table->dropColumn('time');
        });*/
    }
}
