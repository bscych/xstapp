<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoBookMealStudentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('auto_book_meal_students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id')->nullable(false)->comment('学生ID');
            $table->unsignedInteger('class_id')->nullable(false)->comment('课程ID');
            $table->char('attended', 1)->default(0);
            $table->char('dinner', 1)->default(0);
            $table->char('lunch', 1)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('auto_book_meal_students');
    }

}
