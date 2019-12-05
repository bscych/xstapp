<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('student_id')->comment('给哪个学生的账单');
            $table->string('comment')->comment('备注');
            $table->string('income_category')->comment('所属类别，特长课，餐费，托管课等');
            $table->unsignedBigInteger('class_id')->nullable(true)->comment('所属课程');
            $table->integer('finance_year')->comment('财务年');
            $table->integer('finance_month')->comment('财务月');
            $table->double('total',8,2)->comment('总金额');
            $table->string('state')->default('created')->comment('账单状态：created,confirmed,payed,closed');
            $table->dateTime('payed_time')->comment('支付时间')->nullable(true);
            $table->string('bank_receipt')->comment('银行凭证')->nullable(true);
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
        Schema::dropIfExists('bills');
    }
}
