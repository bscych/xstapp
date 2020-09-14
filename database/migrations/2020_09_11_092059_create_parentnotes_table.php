<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parentnotes', function (Blueprint $table) {           
            $table->unsignedInteger('parent_id')->comment('父母ID');
            $table->unsignedInteger('student_id')->comment('留言给谁，学生ID');
            $table->date('date')->comment('父母留言日期');
            $table->string('note')->comment('父母留言')->nullable();
            $table->primary(['parent_id', 'student_id','date']);
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
        Schema::dropIfExists('parentnotes');
    }
}
