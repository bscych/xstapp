<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable($value = true);
            $table->unsignedInteger('course_id')->comment('针对的课程ID'); //课程ID
            $table->unsignedInteger('name_of_account')->nullable($value = true)->comment('会计科目');//如果是退费，那么就是把钱还给家长，否则返回到个人账户
            $table->double('amount', 8, 2)->comment('金额');
            $table->string('payment_method')->nullable($value = true)->comment('支付方式');//当返回到个人账户的时候支付方式可以为空
            $table->integer('finance_year');
            $table->integer('finance_month');
            $table->string('comment')->nullable($value = true);
            $table->unsignedInteger('operator'); //录入人
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
        Schema::dropIfExists('refunds');
    }
}
