<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->softDeletes()->comment('软删');
        });
         Schema::table('class_rooms', function (Blueprint $table) {
            $table->softDeletes()->comment('软删');
        });
         Schema::table('teachers', function (Blueprint $table) {
            $table->softDeletes()->comment('软删');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            //
        });
    }
}
