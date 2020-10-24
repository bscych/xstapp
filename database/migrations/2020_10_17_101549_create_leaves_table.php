<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('老师ID，谁请假');
            $table->string('type')->comment('请假类型：病假，事假，年假')->nullable();
            $table->date('from')->comment('开始日期');
            $table->date('to')->nullable()->comment('结束日期,当请假一天的时候可以为空');
            $table->string('comment')->comment('备注')->nullable();
            $table->char('status', 1)->default(0)->comment('0:老师提交，-1：主管审批不通过，1：主管审批通过');
            $table->softDeletes();
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
        Schema::dropIfExists('leaves');
    }
}
