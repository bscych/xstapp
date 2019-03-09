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

UPDATE `spends` SET `name_of_account`=24 WHERE `name_of_account` = 14 
UPDATE `spends` SET `name_of_account`=23 WHERE `name_of_account` = 8 
UPDATE `spends` SET `name_of_account`=25 WHERE `name_of_account` = 15 
UPDATE `spends` SET `name_of_account`=22 WHERE `name_of_account` = 7 
UPDATE `spends` SET `name_of_account`=18 WHERE `name_of_account` = 5 
UPDATE `spends` SET `name_of_account`=21 WHERE `name_of_account` = 6 

/*2018年10月20日*/
/*insert new data*/
INSERT INTO `constants` (`id`, `parent_id`, `name`, `label_name`, `created_at`, `updated_at`) VALUES (6, NULL, '退费方式', '', '2018-10-20 00:00:00', NULL); 
INSERT INTO `constants` (`id`, `parent_id`, `name`, `label_name`, `created_at`, `updated_at`) VALUES (34, 6, '返现', '', '2018-10-20 00:00:00', NULL) ;
INSERT INTO `constants` (`id`, `parent_id`, `name`, `label_name`, `created_at`, `updated_at`) VALUES (35, 6, '返回到帐户', '', '2018-10-20 00:00:00', NULL); 
INSERT INTO `constants` (`id`, `parent_id`, `name`, `label_name`, `created_at`, `updated_at`) VALUES (36, 4, '杂费', '', '2018-10-20 13:30:00', NULL) ;
INSERT INTO `constants` (`id`, `parent_id`, `name`, `label_name`, `created_at`, `updated_at`) VALUES (37, 4, '车费', '', '2018-10-21 20:30:00', NULL) ;

/*update course table*/
UPDATE `courses` SET `course_category_id`=12 WHERE `course_category_id`=16 ;
UPDATE `courses` SET `course_category_id`=13 WHERE `course_category_id`=18 ;
UPDATE `courses` SET `course_category_id`=14 WHERE `course_category_id`=19 ;
UPDATE `courses` SET `course_category_id`=14 WHERE `id`=20004;
UPDATE `courses` SET `course_category_id`=15 WHERE `course_category_id`=20; 
UPDATE `courses` SET `course_category_id`=16 WHERE `course_category_id`=21;

/*update income table*/
UPDATE `incomes` SET `name_of_account`=28 WHERE `amount`>699 
UPDATE `incomes` SET `comment` = '幼小教材费' WHERE `incomes`.`id` = 58; 
UPDATE `incomes` SET `comment` = '幼小教材费' WHERE `incomes`.`id` = 63; 
UPDATE `incomes` SET `comment` = '幼小教材费' WHERE `incomes`.`id` = 65; 
UPDATE `incomes` SET `comment` = '舞蹈服费用' WHERE `incomes`.`id` = 61;
UPDATE `incomes` SET `name_of_account`=29 WHERE comment LIKE '%教材%' ;
UPDATE `incomes` SET `comment` = '8月份幼儿园托管半价' WHERE `incomes`.`id` = 87; 
UPDATE `incomes` SET `comment` = '9月份幼儿园托管半价' WHERE `incomes`.`id` = 88; 
UPDATE `incomes` SET `name_of_account`=28 WHERE `comment` LIKE '%幼儿园托管半价%' ;
UPDATE `incomes` SET `name_of_account`=36 WHERE `comment` LIKE '%舞蹈服费%' ;
UPDATE `incomes` SET `name_of_account`=36 WHERE `comment` LIKE '%车费%' ;
UPDATE `incomes` SET `name_of_account` = 29 WHERE `incomes`.`id` = 12;
UPDATE `incomes` SET `name_of_account` = 29 WHERE `incomes`.`id` = 23;
UPDATE `incomes` SET `name_of_account` = 29 WHERE `incomes`.`id` = 30;
UPDATE `incomes` SET `name_of_account` = 29 WHERE `incomes`.`id` = 46;
/* payment method*/
UPDATE `incomes` SET `payment_method` = '银行转账' WHERE `incomes`.`id` = 3; 
UPDATE `incomes` SET `payment_method`='支付宝' WHERE payment_method = 4; 
UPDATE `incomes` SET `payment_method`='POS' WHERE payment_method = 1; 
UPDATE `incomes` SET `payment_method`='现金' WHERE payment_method = 2 ;
UPDATE `incomes` SET `payment_method`='微信' WHERE payment_method = 3 ;

/*
UPDATE `incomes` SET `payment_method` = 17 WHERE `incomes`.`id` = 3; 
UPDATE `incomes` SET `payment_method`=10 WHERE payment_method = 4; 
UPDATE `incomes` SET `payment_method`=8 WHERE payment_method = 1; 
UPDATE `incomes` SET `payment_method`=11 WHERE payment_method = 2 ;
UPDATE `incomes` SET `payment_method`=9 WHERE payment_method = 3 ;
*/

/*update spend table*/

UPDATE `spends` SET `name_of_account`= 27 WHERE `name_of_account`= 24; 
UPDATE `spends` SET `name_of_account`= 26 WHERE `name_of_account`= 25; 
UPDATE `spends` SET `name_of_account`= 25 WHERE `name_of_account`= 15;
UPDATE `spends` SET `name_of_account`= 24 WHERE `name_of_account`= 14;
UPDATE `spends` SET `name_of_account`= 23 WHERE `name_of_account`= 8;
UPDATE `spends` SET `name_of_account`= 22 WHERE `name_of_account`= 7;
UPDATE `spends` SET `name_of_account`= 21 WHERE `name_of_account`= 6;
UPDATE `spends` SET `name_of_account`= 18 WHERE `name_of_account`= 5;  

/*update enrolls table*/
UPDATE `enrolls` SET `income_account`=28 WHERE `course_id` <> 20000;
UPDATE `enrolls` SET `name` = '2018年10月车费' WHERE `enrolls`.`id` = 154; 
UPDATE `enrolls` SET `name` = '2018年9月车费' WHERE `enrolls`.`id` = 155; 
UPDATE `enrolls` SET `name` = '2018年9月、10月车费' WHERE `enrolls`.`id` = 152; 
UPDATE `enrolls` SET `name` = '2018年9月、10月车费' WHERE `enrolls`.`id` = 156; 
UPDATE `enrolls` SET `income_account`=37 WHERE `name` LIKE '%车费%';

UPDATE `enrolls` SET `name` = '舞蹈服费用' WHERE `enrolls`.`id` = 159;
UPDATE `enrolls` SET `name` = '舞蹈服费用' WHERE `enrolls`.`id` = 163;
UPDATE `enrolls` SET `name` = '舞蹈服费用' WHERE `enrolls`.`id` = 158;
UPDATE `enrolls` SET `name` = '舞蹈服费用' WHERE `enrolls`.`id` = 105;
UPDATE `enrolls` SET `income_account`=36 WHERE `name` LIKE '%舞蹈服%';

UPDATE `enrolls` SET `name`='幼小教材费' WHERE `paid`=450;
UPDATE `enrolls` SET `name` = '二年级英语教材费' WHERE `enrolls`.`id` = 100;
UPDATE `enrolls` SET `name`='一年级英语教材费' WHERE `paid`=118 ;
UPDATE `enrolls` SET `name`='二年级英语教材费' WHERE `paid`=124.4 ;
UPDATE `enrolls` SET `name` = '教材费' WHERE `enrolls`.`id` = 67; 
UPDATE `enrolls` SET `name` = '教材费' WHERE `enrolls`.`id` = 64; 
UPDATE `enrolls` SET `income_account` = 29 WHERE `name` LIKE '%教材%';



UPDATE `enrolls` SET `name` = '幼儿园托管半价' WHERE `enrolls`.`id` = 72; 
UPDATE `enrolls` SET `name` = '幼儿园托管半价' WHERE `enrolls`.`id` = 77; 
UPDATE `enrolls` SET `name` = '幼儿园托管半价' WHERE `enrolls`.`id` = 78; 
UPDATE `enrolls` SET `name` = '幼儿园托管半价' WHERE `enrolls`.`id` = 96; 

UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 131; 
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 146;
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 123;
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 124;

UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 147;
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 150;
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 148;
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 121;
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 140;
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 132;
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 117; 
UPDATE `enrolls` SET `name` = '2018年9月份餐费' WHERE `enrolls`.`id` = 145; 
UPDATE `enrolls` SET `income_account`=30 ,`name`='2018年9月份餐费' WHERE `course_id`=20000 AND `income_account` =0;

UPDATE `enrolls` SET `course_id` = '4' WHERE `enrolls`.`id` = 160;
UPDATE `enrolls` SET `course_id` = '4' WHERE `enrolls`.`id` = 161;
UPDATE `enrolls` SET `course_id` = '4' WHERE `enrolls`.`id` = 162;
