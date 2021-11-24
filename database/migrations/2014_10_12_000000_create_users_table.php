<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('username')->nullable();
          $table->timestamp('email_verified_at')->nullable();
          $table->smallInteger('role')->default(User::ROLE_USER);
          $table->string('password');
          $table->string('objectguid');
          $table->string('pager')->nullable();
          $table->string('department')->nullable();
          $table->string('homePhone')->nullable();
          $table->string('email')->nullable();
          $table->string('mail')->nullable();
          $table->string('sAMAccountName');
          $table->string('title')->nullable();
          $table->string('physicalDeliveryOfficeName')->nullable();
          $table->string('telephoneNumber')->nullable();
          $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
