<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('birthday');
//            $table->char('contracted',1)->comment('合作老师，1：是校外合作老师，0：不是校外合作老师');
            $table->date('start_at')->nullable()->comment('则可以设置老师的入职时间');
            $table->integer('salary')->nullable()->comment('基本工资');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher', function (Blueprint $table) {
            //
        });
    }
}
