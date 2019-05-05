
@extends('layouts.new')

@section('content')
<!-- Page Heading/Breadcrumbs -->
<h1 class="mt-4 mb-3">
    <small>如何使用小书童自助订餐系统
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
          <p class="lead">3. 选择 我是家长，进行注册</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/imparent.png')}}" alt="">

        <hr>
          <p class="lead">4. 填写和孩子的关系，验证码，然后点击注册</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/register.jpg')}}" alt="">

        <hr>
        
         <p class="lead">5. 注册成功会显示一下页面，表明已经和孩子绑定关系，点击孩子姓名按钮</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/kids.png')}}" alt="">

        <hr>
          <p class="lead">6. 页面显示孩子可以报餐的课程，点击订餐，进行报餐</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/courses.png')}}" alt="">

        <hr>
          <p class="lead">7. 系统会显示7-8天的日历，可以选择某一天进行报餐，家长需要提前预报下周用餐情况，当天上午9点前可以随时更改，上午9点以后不允许更改当天报餐的情况。</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/calendar.png')}}" alt="">

        <hr>
           <p class="lead">8. 选择某一天，系统会显示当天的菜谱，请家长根据当天菜谱为孩子报餐，勾选之后系统就会记录报餐的情况。</p>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('img/helpers/menu.png')}}" alt="">
        <hr>
      
    </div>

</div>
<!-- /.row -->
@endsection

