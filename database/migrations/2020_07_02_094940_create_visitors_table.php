<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id')->comment('school id')->default(1);
            $table->string('name')->comment('孩子名字');
             $table->string('gender', 2)->comment('性别');
            $table->date('birthday')->comment('孩子生日')->nullable();
            $table->string('parent_name')->nullable()->comment('父母的名字');
            $table->string('phone')->nullable(false)->comment('联系电话，方式');
            $table->string('interests')->comment('感兴趣的课程')->nullable();
            $table->longText('contact_history')->comment('联系历史')->nullable();
             $table->softDeletes()->comment('软删除');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('visitors');
    }

}
