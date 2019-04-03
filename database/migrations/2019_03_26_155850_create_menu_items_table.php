<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('menuItems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('菜品名称')->unique();
            $table->string('ingredients')->comment('配料'); //间点，午餐或晚餐;
            $table->string('recipe')->comment('食谱配方'); //间点，午餐或晚餐;
            $table->string('is_vegetarian')->comment('是否素菜 1 是 0 不是');//是否素菜
            $table->softDeletes()->comment('软删');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('menuItems');
    }

}
