<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <link href="{{asset('css/bootstrap-cerulean.min.css')}}" rel="stylesheet">

        <link href="{{ asset('css/charisma-app.css')}}" rel="stylesheet">

        <link rel="icon" href="{{asset('/img/logo20.png')}}" mce_href="{{asset('/img/logo20.png')}}" type="image/x-icon">
    </head>
    <body>

        <!-- topbar starts -->
        <div class="navbar navbar-default" role="navigation">

            <div class="navbar-inner">
           
                <button type="button" class="navbar-toggle pull-left animated flip">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"> <img alt="Logo" src="{{asset('/img/logo20.png')}}" class=""/>
                    </a>
                <p class="pull-right navbar-brand">{{Auth::user()==null?'':'你好！'.Auth::user()->name }}</p>
            </div>
        </div>
        <!-- topbar ends -->

        <div class="ch-container">
            <div class="row">
                  <!-- left menu starts -->
                <div class="col-sm-2 col-lg-2">
                    <div class="sidebar-nav">
                        <div class="nav-canvas">
                            <div class="nav-sm nav nav-stacked">

                            </div>
                            <ul class="nav nav-pills nav-stacked main-menu">
                                <li class="nav-header">菜单</li>

                                @hasanyrole('admin|superAdmin')
                                <!--li><a class="ajax-link" href="{{ url('/constantName') }}"><i class="glyphicon glyphicon-plus"></i><span> 数据字典管理</span></a>
                                </li-->
                                <li><a class="ajax-link" href="{{ url('/constant') }}"><i class="glyphicon glyphicon-plus"></i><span> 数据字典</span></a>
                                </li>
                                <li><a class="ajax-link" href="{{ url('/student') }}"><i class="glyphicon glyphicon-list-alt"></i><span> 学生管理</span></a>
                                <li><a class="ajax-link" href="{{ url('/menuItem') }}"><i class="glyphicon glyphicon-eye-open"></i><span>菜品管理</span></a></li>
                                <li><a class="ajax-link" href="{{ url('/menu') }}"><i class="glyphicon glyphicon-eye-open"></i><span>菜单管理</span></a></li>
                                <li><a class="ajax-link" href="{{ url('/classroom') }}"><i class="glyphicon glyphicon-eye-open"></i><span>教室管理</span></a></li>

                                <li><a class="ajax-link" href="{{ url('/user') }}"><i class="glyphicon glyphicon-font"></i><span>用户管理</span></a>
                                </li>
                                <li><a class="ajax-link" href="{{ url('/role') }}"><i class="glyphicon glyphicon-picture"></i><span>角色管理</span></a>
                                </li>
                                <li class="accordion">
                                    <a href="#"><i class="glyphicon glyphicon-plus"></i><span> 财务管理</span></a>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a href="{{ url('/spend') }}">支出管理</a></li>
                                        <li><a href="{{ url('/income') }}">收入管理</a></li>
                                        @role('superAdmin')
                                        <li><a href="{{ url('/monthList') }}">报表</a></li>
                                        @endrole 
                                    </ul>
                                </li>
                                <li><a class="ajax-link" href="{{ url('/holiday') }}"><i class="glyphicon glyphicon-align-justify"></i><span> 假期管理</span></a></li>
                                @endhasanyrole

                                 @hasanyrole('admin|superAdmin|supervisor')
                                 <li><a class="ajax-link" href="{{ url('/course') }}"><i class="glyphicon glyphicon-edit"></i><span> 课程管理</span></a></li>
                                 @endhasanyrole
                                 
                                @hasanyrole('admin|teacher|supervisor')
                               
                                <li><a class="ajax-link" href="{{ url('/class') }}"><i class="glyphicon glyphicon-edit"></i><span> 班级管理</span></a></li>
                                <li><a class="ajax-link" href="{{ route('code.index') }}"><i class="glyphicon glyphicon-edit"></i><span> 查询注册码</span></a></li>
                                @endhasanyrole

                            </ul>

                        </div>
                    </div>
                </div>

                <div id="content" class="col-lg-10 col-sm-10">
                    <!-- content starts -->
                    @yield('content')
                </div>
            </div>
            <hr>
            <footer class="row">
                <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy; <a href="#" target="_blank">普瑞教育</a> {{date('Y')}}</p>

                <p class="col-md-3 col-sm-3 col-xs-12 powered-by">Powered by: <a
                        href="#">普瑞教育</a></p>
            </footer>
        </div>
        <!-- Scripts -->
        <!--script src="{{ asset('js/app.js') }}"></script-->
        <script src="{{ asset('bower_components/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- calender plugin -->
        <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>

        <!-- data table plugin -->
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

        <!-- library for making tables responsive -->
        <script src="{{ asset('bower_components/responsive-tables/responsive-tables.js') }}"></script>

        <!-- application script for Charisma demo -->
        <script src="{{ asset('js/charisma.js') }}"></script>

        <script src="{{ asset('js/course.js') }}"></script>




        <script type="text/javascript">
           
        </script>
    </body>
</html>
