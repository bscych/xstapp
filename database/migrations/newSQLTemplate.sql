/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  bscyc
 * Created: 2018-9-20
 */
ALTER TABLE `students` 
ADD `gender` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  DEFAULT '男' COMMENT '性别' AFTER `name`;

ALTER TABLE `students` 
ADD `nation` VARCHAR(50)  COMMENT '民族' AFTER `birthday`, 
ADD `health` VARCHAR(200)  COMMENT '健康状况' AFTER `nation`, 
ADD `interest` VARCHAR(200)  AFTER `health`, 
ADD `home_address` VARCHAR(200)  AFTER `interest`, 
ADD `parents_info` VARCHAR(500)  AFTER `home_address`, 
ADD `school` VARCHAR(200)  AFTER `parents_info`, 
ADD `grade` INT(5)  AFTER `school`, 
ADD `class_room` INT(5)  AFTER `grade`, 
ADD `class_supervisor_name` VARCHAR(100)  AFTER `class_room`, 
ADD `class_supervisor_phone` VARCHAR(100)  AFTER `class_supervisor_name`, 
ADD `chinese` DOUBLE  AFTER `class_supervisor_phone`, 
ADD `math` DOUBLE  AFTER `chinese`, 
ADD `english` DOUBLE  AFTER `math`, 
ADD `study_brief` VARCHAR(500)  AFTER `english`, 
ADD `live_brief` VARCHAR(500)  AFTER `study_brief`, 
ADD `character_brief` VARCHAR(500)  AFTER `live_brief`,
ADD `expectation` VARCHAR(500)  AFTER `character_brief`, 
ADD `expect_courses` VARCHAR(500)  AFTER `expectation`;

/*
2018-09-21
*/

ALTER TABLE `courses` ADD `unit` VARCHAR(20) NOT NULL DEFAULT '课时' COMMENT '单位' AFTER `name`;
ALTER TABLE `courses` CHANGE `duration` `duration` DOUBLE(6,2) NOT NULL;
ALTER TABLE `students` ADD `balance` DOUBLE(10,1) NOT NULL COMMENT '账户余额' AFTER `updated_at`;
ALTER TABLE `incomes` CHANGE `payer` `paid_by` INT(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `incomes` ADD `comment` VARCHAR(200) NULL AFTER `operator`;
ALTER TABLE `incomes` CHANGE `name_of_account` `name_of_account` INT(10) UNSIGNED NULL;
ALTER TABLE `students` CHANGE `balance` `balance` DOUBLE(10,1) NOT NULL DEFAULT '0' COMMENT '账户余额';
ALTER TABLE `students` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
CHANGE `birthday` `birthday` DATE NULL DEFAULT NULL, 
CHANGE `nation` `nation` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '民族', 
CHANGE `health` `health` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '健康状况', 
CHANGE `interest` `interest` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '兴趣爱好', 
CHANGE `home_address` `home_address` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `parents_info` `parents_info` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, 
CHANGE `school` `school` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `grade` `grade` INT(5) NULL, CHANGE `class_room` `class_room` INT(5) NULL, 
CHANGE `class_supervisor_name` `class_supervisor_name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `class_supervisor_phone` `class_supervisor_phone` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `chinese` `chinese` DOUBLE NULL, CHANGE `math` `math` DOUBLE NULL, CHANGE `english` `english` DOUBLE NULL, 
CHANGE `study_brief` `study_brief` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `live_brief` `live_brief` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `character_brief` `character_brief` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `expectation` `expectation` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `expect_courses` `expect_courses` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, 
CHANGE `created_at` `created_at` TIMESTAMP NULL DEFAULT NULL, CHANGE `updated_at` `updated_at` TIMESTAMP NULL DEFAULT NULL;
/*
ALTER TABLE `class_rooms` COMMENT = '教室';
*/

/*
2018-09-23
*/
ALTER TABLE `teachers` CHANGE `name` `role` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, 
CHANGE `birthday` `birthday` DATE NULL DEFAULT NULL, 
CHANGE `created_at` `created_at` TIMESTAMP NULL DEFAULT NULL, 
CHANGE `updated_at` `updated_at` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `teachers` ADD `user_id` INT(10) UNSIGNED NOT NULL COMMENT '用户ID' AFTER `id`;

/*
2018-9-27
*/
ALTER TABLE `courses` CHANGE `duration,` `duration` DOUBLE(6,2) NOT NULL; 

/*
2018-9-28

*/
ALTER TABLE `enrolls` CHANGE `teacher_id` `student_id` INT(10) UNSIGNED NOT NULL; 
ALTER TABLE `courses` CHANGE `which_day_1` `which_day_1` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `block1_start_time` `block1_start_time` TIME NULL,
 CHANGE `block1_end_time` `block1_end_time` TIME NULL, 
CHANGE `which_day_2` `which_day_2` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, 
CHANGE `block2_start_time` `block2_start_time` TIME NULL,
CHANGE `block2_end_time` `block2_end_time` TIME NULL; 
ALTER TABLE `course_student` ADD `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD INDEX (`id`); 

/*
2018-9-29
*/
ALTER TABLE `courses` ADD `end_date` DATE  NULL COMMENT '结束时间' AFTER `start_date`; 

/*
2018-10-1
*/
ALTER TABLE `spends` CHANGE `which_day` `which_day` DATE NOT NULL COMMENT '发生日期'; 
ALTER TABLE `spends` ADD `finance_year` INT(4) NOT NULL COMMENT '财务年份' AFTER `payment_method`, 
ADD `finance_month` INT(2) NOT NULL COMMENT '财务月份' AFTER `finance_year`;
ALTER TABLE `spends` ADD `comment` VARCHAR(200) NULL COMMENT '备注' AFTER `which_day`; 

/*从服务器上先执行的语句*/
ALTER TABLE `incomes` CHANGE `hours` `finance_year` INT(4) NOT NULL COMMENT '财务年份';
ALTER TABLE `incomes` CHANGE `course_id` `finance_month` INT(4) NULL COMMENT '财务月份';

/*
2018-10-2
*/

ALTER TABLE `schedules` CHANGE `course_id` `classmodel_id` INT(10) UNSIGNED NOT NULL;
ALTER TABLE `course_student` ADD PRIMARY KEY(`id`);
ALTER TABLE `classmodels` ADD `name` VARCHAR(100) NOT NULL DEFAULT '一班' COMMENT '班级名称' AFTER `id`;
ALTER TABLE `course_student` ADD `classmodel_id` INT(10) UNSIGNED NOT NULL COMMENT '班级ID' ; 
ALTER TABLE `course_student` CHANGE `classmodel_id` `classmodel_id` INT(10) UNSIGNED NULL COMMENT '班级ID'; 

/*
2018-10-3,4
*/

ALTER TABLE `schedules` CHANGE `ende` `end` TIME NOT NULL;
ALTER TABLE `schedules` CHANGE `start` `start_time` TIME NOT NULL; 
ALTER TABLE `schedules` CHANGE `end` `end_time` TIME NULL COMMENT '结束时间'; 
ALTER TABLE `schedules` CHANGE `start_time` `start_time` TIME NULL COMMENT '开始时间'; 
ALTER TABLE `schedule_student` CHANGE `attended` `attended` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0', 
CHANGE `lunch` `lunch` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0', 
CHANGE `dinner` `dinner` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'; 