<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeworksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('homeworks', function (Blueprint $table) {
          
            $table->date('date')->comment('学校作业的日期')->nullable(false);
            $table->string('school_name')->comment('哪个学校的作业')->nullable(false);
            $table->integer('grade')->comment('年级哪个年级的')->nullable(false);
            $table->integer('class')->comment('班级哪个班级的')->nullable(false);

            $table->string('chinese',512)->comment('语文作业')->nullable();
            $table->string('math',512)->comment('数学作业')->nullable();
            $table->string('english',512)->comment('英语作业')->nullable();
            
            $table->primary(['date', 'school_name', 'grade', 'class']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('homeworks');
    }

}
