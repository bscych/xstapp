<nav class="navbar navbar-expand-md navbar-light bg-white font-light">
  <a class="navbar-brand" href="{{route('home')}}">{{ config('app.name') }}
    <img src="{{asset('img/logo.png')}}" height="30px" alt="{{ config('app.name') }}"> 
    </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
		@guest
			
		@else
		@hasanyrole('admin|superAdmin')
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">基本配置</a>
		  <div class="dropdown-menu" aria-labelledby="dropdown01">
		    <a class="dropdown-item" href="{{ url('/holiday') }}">特殊日期管理</a>
		    <a class="dropdown-item" href="{{ url('/menuItem') }}">菜品管理</a>
		    <a class="dropdown-item" href="{{ url('/menu') }}">菜单管理</a>
			<a class="dropdown-item" href="{{ url('/user') }}">用户管理</a>
			<a class="dropdown-item" href="{{ url('/role') }}">角色管理</a>
			<a class="dropdown-item" href="{{ url('/constant') }}">数据字典</a>
		  </div>
		</li>
		
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">财务管理</a>
		  <div class="dropdown-menu" aria-labelledby="dropdown02">
		    <a class="dropdown-item" href="{{ route('bill.index') }}">账单管理</a>
		    <a class="dropdown-item" href="{{ url('/spend') }}">支出管理</a>
		    <a class="dropdown-item" href="{{ url('/income') }}">收入管理</a>
			 @role('superAdmin')
			<a class="dropdown-item" <a href="{{ url('/monthList') }}">报表</a>
	         @endrole 
		  </div>
		</li>
		
		
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/student') }}">学生管理</a>
      </li>
	  @endhasanyrole
	  
	  @hasanyrole('admin|teacher|supervisor|superAdmin')
	  <li><a class="nav-link" href="{{ url('/class') }}">班级管理</a></li>
	  <li><a class="nav-link" href="{{ route('code.index') }}"> 查询注册码</a></li>
	  <li><a class="nav-link" href="{{ route('getMyWorkingSheet') }}"> 我的特长课时统计</a></li>
	  @endhasanyrole
	  
	  
	  @hasanyrole('admin|superAdmin|supervisor')
	  <li><a class="nav-link" href="{{ url('/course') }}"> 课程管理</a></li>
	  @endhasanyrole
	  <li><a class="nav-link" href="{{ route('menu.thisweek') }}">本周餐谱</a></li>
	  @hasrole('parent')
	  <li><a class="nav-link" href="{{ route('showParentRegisterForm') }}">添加孩子</a></li>
	  <li><a class="nav-link" href="{{ route('wechat.home') }}">订餐</a></li>
	  @endhasrole
    </ul>
	@endguest

	

   <div class=" my-2 my-lg-0">
	@guest
	<a href="{{ route('login') }}">登录</a>
	@else
	<a>{{Auth::user()->name }} 欢迎您 </a>
	@endguest
    </div>

  </div>
</nav>
