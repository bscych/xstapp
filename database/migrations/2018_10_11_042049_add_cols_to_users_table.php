<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->string('openid')->nullable($value = true)->comment('微信的openid');
           $table->string('nickname')->nullable($value = true)->comment('昵称');
           $table->string('sex')->nullable($value = true)->comment('性别');
           $table->string('city')->nullable($value = true)->comment('城市');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
