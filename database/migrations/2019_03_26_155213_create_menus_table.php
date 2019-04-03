<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable($value = true);
            $table->date('which_day')->comment('哪一天的菜谱');
            $table->string('meal')->comment('哪一餐：上午间点，午餐，下午间点，晚餐'); //间点，午餐或晚餐;
            $table->softDeletes()->comment('软删');
            $table->timestamps();
            $table->index(['which_day', 'meal']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
