<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMealProvideFlagToCourseTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function (Blueprint $table) {
            $table->char('has_lunch',1)->comment('是否提供午餐,0：不提供，1：提供')->after('in_count')->nullable(false)->default(1);
            $table->char('has_dinner',1)->comment('是否提供晚餐，0：不提供，1：提供')->after('in_count')->nullable(false)->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('courses', function (Blueprint $table) {
            //
        });
    }

}
