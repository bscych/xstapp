
@extends('layouts.wechat')

@section('content')
<!-- Page Heading/Breadcrumbs -->
<h1 class="mt-4 mb-3">
    <small>如何使用教师考勤系统
    </small>
</h1>

<div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-10">
        <hr>
        <p class="lead">1. 请先关注小书童教育中心的公众号</p>
        <!-- Preview Image -->
        <img class="img-fluid center rounded" src="{{asset('img/wc.jpg')}}" alt="">

        <hr>

         <p class="lead">2. 成功关注后点击最后一个菜单：实用工具</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/tools.jpg')}}" alt="">

        <hr>
          <p class="lead">3. 选择 我是老师，进行注册</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/imteacher.png')}}" alt="">

        <hr>
          <p class="lead">4. 使用邮箱和密码登录</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/login.PNG')}}" alt="">

        <hr>
        
         <p class="lead">5. 登陆后显示如下图，点击左上角的菜单按钮</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/homepage.png')}}" alt="">

        <hr>
          <p class="lead">6 选择“班级管理”</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/classmenu.png')}}" alt="">

        <hr>
          <p class="lead">6.1.1 系统显示登录老师所教授的课程，老师可以查看以往的打卡记录（考勤报表），也可以对当天的课程进行考勤（考勤管理）</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/classlist.png')}}" alt="">

        <hr>
           <p class="lead">6.1.2. 当老师选择考勤管理时，系统会显示，今天的日历，如果今天不上课，则不会出现今天的日历，考勤只能在当天进行，不能提前一天或者延后一天</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/classOfToday.png')}}" alt="">
        <hr>
       <hr>
           <p class="lead">6.1.3. 老师点击今天的日历，系统会显示参加课程的同学列表，老师勾选同学对应的出勤勾选框，系统就会记录该学生今天出勤, 反之系统会记录该学生今天没出勤</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/studentList.png')}}" alt="">
        <hr>
           <p class="lead">6.2.1 选择考勤报表，系统会显示本月已经上了几次课，以及出勤人数</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/scheduleStatistics.png')}}" alt="">
        
         <hr>
           <p class="lead">6.2.2 点击本月明细，系统会显示本月上课的日期以及学生出勤的详细列表，点击上月考勤，显示上个月的考勤明细</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/currentMonthStatistics.png')}}" alt="">
    
    </div>

</div>
<!-- /.row -->
@endsection

