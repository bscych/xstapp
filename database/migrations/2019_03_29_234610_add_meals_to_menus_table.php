<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMealsToMenusTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('afternoon_snack')->comment('哪一餐：下午间点')->after('which_day')->nullable(true);
            $table->string('dinner')->comment('哪一餐：晚餐')->after('which_day')->nullable(true);
            $table->renameColumn('name', 'lunch')->comment('哪一餐：午餐')->after('which_day')->nullable(true);
            $table->renameColumn('meal', 'morning_snack')->comment('哪一餐：上午间点')->after('which_day')->nullable(true);
            $table->unique('which_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('menus', function (Blueprint $table) {
            //
        });
    }

}
