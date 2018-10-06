<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpendsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('constant_names', function (Blueprint $table) {
            $table->increments('id');
            $table->string('constant_name')->unique();
            $table->timestamps();
        });


        Schema::create('constant_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('constant_name_id');
            $table->foreign('constant_name_id')->references('id')->on('constant_names');
            $table->string('constant_value')->unique();
            $table->string('label_name')->nullable();
            $table->timestamps();
        });

        Schema::create('classrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('spends', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_of_account');
            $table->double('amount', 8, 2);
            $table->string('payment_method'); //缴费方式，与数据字典关联
            $table->date('which_day');
            $table->unsignedInteger('operator'); //操作人，与user关联
            $table->timestamps();
        });

        Schema::create('incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('paid_by'); //缴费人，与student 关联
            $table->string('payment_method'); //缴费方式，与数据字典关联
            //   $table->integer('hours')->nullable(); //所报课时时常
            //   $table->unsignedInteger('course_id')->nullable(); //所报课程，课程ID
            $table->double('amount', 8, 2); //金额
            $table->string('comment'); //备注
            $table->unsignedInteger('operator'); //录入人
            $table->timestamps();
        });


        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('gender');
            $table->date('birthday')->nullable();
            $table->string('nation')->nullable(); //民族
            $table->string('health')->nullable(); //健康
            $table->string('interest')->nullable();
            $table->string('home_address')->nullable();
            $table->string('parents_info')->nullable();

            $table->string('school');
            $table->integer('grade')->nullable();
            $table->integer('class_room')->nullable();
            $table->string('class_supervisor_name')->nullable();
            $table->string('class_supervisor_phone')->nullable();

            $table->double('chinese', 4, 2)->nullable();
            $table->double('math', 4, 2)->nullable();
            $table->double('english', 4, 2)->nullable();

            $table->string('study_brief')->nullable();

            $table->string('live_brief')->nullable();

            $table->string('character_brief')->nullable();

            $table->string('expectation')->nullable();

            $table->string('expect_courses')->nullable();
            $table->double('balance', 10, 1)->nullable(); //账户余额
            $table->unsignedInteger('operator'); //操作人
            $table->timestamps();
        });
        Schema::create('stuffs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); //对应users的主键
            $table->string('role'); //对应constant_values的主键
            $table->date('birthday')->nullable();
            $table->unsignedInteger('operator'); //操作人
            $table->timestamps();
        });
        Schema::create('courses', function (Blueprint $table) {//培训课程,课后托管
            $table->increments('id');
            $table->string('name');
            $table->string('unit'); //单位，托管是以月为单位，特长课是以课时为单位
            $table->double('unit_price', 8, 2); //课程单价,小时为单位，托管单价，月为单位
            $table->double('duration', 6, 2); //课时长度，以小时为单位，托管，月为单位
            $table->unsignedInteger('course_category_id'); //课程类别，英语，书法，舞蹈，美术，小学托管，幼儿园托管，数据字典关联
            $table->unsignedInteger('teacher_id'); //关联users表
            $table->unsignedInteger('classroom_id'); //关联教室表
            $table->date('start_date');
            $table->date('end_date');
            $table->string('which_day_1'); //1=one time a week, 2 = 2 times a week
            $table->time('block1_start_time');
            $table->time('block1_end_time');
            $table->string('which_day_2'); //1=one time a week, 2 = 2 times a week
            $table->time('block2_start_time');
            $table->time('block2_end_time');
            $table->timestamps();
        });

        Schema::create('course_student', function (Blueprint $table) {
            $table->unsignedInteger('course_id'); //课ID
            $table->unsignedInteger('student_id'); //学生ID
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('classmodel_id'); //课ID
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
             $table->timestamps();
        });
        Schema::create('schedule_student', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id'); //计划ID
            $table->unsignedInteger('student_id'); //学生ID
            $table->char('attended', 1);
            $table->char('lunch', 1);
            $table->char('dinner', 1);
        });

        Schema::create('enrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id'); //课程id
            $table->unsignedInteger('teacher_id'); //关联users表
            $table->double('paid', 8, 2); //扣费金额

            $table->unsignedInteger('operator'); //操作人
            $table->timestamps();
        });
        
         Schema::create('classmodels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('一班');
            $table->unsignedInteger('course_id')->comment('课程ID');
            $table->unsignedInteger('teacher_id')->comment('班主任ID');
            $table->unsignedInteger('classroom_id')->comment('教室ID');
            $table->date('start_date')->comment('开始时间'); 
            $table->date('end_date')->comment('结束世间');
            
            $table->string('which_day_1')->nullable($value = true)->comment('每周的哪一天'); //1=one time a week, 2 = 2 times a week
            $table->time('block1_start_time')->nullable($value = true)->comment('开始时间');
            $table->time('block1_end_time')->nullable($value = true)->comment('结束时间');
            $table->string('which_day_2')->nullable($value = true)->comment('每周的哪一天'); //1=one time a week, 2 = 2 times a week
            $table->time('block2_start_time')->nullable($value = true)->comment('开始时间');
            $table->time('block2_end_time')->nullable($value = true)->comment('结束时间');
            $table->timestamps();
        });
        
         Schema::create('course_classmodel', function (Blueprint $table) {
            $table->increments('id');
         
            $table->unsignedInteger('course_id')->comment('课程ID');
            $table->unsignedInteger('classmodel_id')->comment('班级ID');
           
            $table->timestamps();
        });

//         Schema::create('schedule', function (Blueprint $table) {
//            $table->increments('id');
//            $table->unsignedInteger('course-id');
//            $table->date('which_date');
//            
//            $table->timestamps();
//        });

        initData();
    }

    public function initData() {
        DB::table('constant_names')->insert(['name' => '交费类型',]);
        DB::table('constant_names')->insert(['name' => '课程类型',]);
        DB::table('constant_names')->insert(['name' => '会计科目',]);
        DB::table('constant_names')->insert(['name' => '学生状态',]);
        // DB::table('constant_categories')->insert(['name' => 'Teacher Status',]);
        //DB::table('constant_categories')->insert([ 'name' => '班级状态',]);
        // DB::table('constant_categories')->insert([ 'name' => '角色',]);
        // DB::table('constant_names')->insert(['name' => str_random(10), ]);
        //DB::table('constant_categories')->insert([ 'name' => str_random(10), ]);

        DB::table('constant_values')->insert([
            'constant_name_id' => 1,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 1,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 1,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 1,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 1,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 2,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 2,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 2,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 2,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 2,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 3,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 3,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 3,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 3,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 3,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 4,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 4,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 5,
            'constant_value' => 'Admin',
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 5,
            'constant_value' => 'Sales',
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 5,
            'constant_value' => 'Teacher',
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 5,
            'constant_value' => 'Student',
            'label_name' => str_random(10)
        ]);
        DB::table('constant_values')->insert([
            'constant_name_id' => 5,
            'constant_value' => str_random(10),
            'label_name' => str_random(10)
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'bscych@hotmail.com',
            'password' => '$2y$10$iRYX9FH4mgL8Xyi0./2ur.n9Mvc.vljOPvoPLB.HdgvsvBlDQEl5.'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('constant_names');
        Schema::dropIfExists('constant_values');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('classrooms');
        Schema::dropIfExists('spends');
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('students');
        Schema::dropIfExists('teachers');

        Schema::dropIfExists('courses');
        Schema::dropIfExists('course_student');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('schedule_student');
        Schema::dropIfExists('enrolls');
        Schema::dropIfExists('classmodels');
         Schema::dropIfExists('course_classmodel');
    }

}
