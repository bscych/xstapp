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
    <link href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.css')}}" rel='stylesheet'>
    <link href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.print.css')}}" rel='stylesheet' media='print'>
    <link href="{{ asset('bower_components/chosen/chosen.min.css')}}" rel='stylesheet'>
    <link href="{{ asset('bower_components/colorbox/example3/colorbox.css')}}" rel='stylesheet'>   
    <link href="{{ asset('bower_components/responsive-tables/responsive-tables.css')}}" rel='stylesheet'>
    <link href="{{ asset('bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css')}}" rel='stylesheet'>
    <link href="{{ asset('css/jquery.noty.css')}}" rel='stylesheet'>
    <link href="{{ asset('css/noty_theme_default.css')}}" rel='stylesheet'>
    <link href="{{ asset('css/elfinder.min.css')}}" rel='stylesheet'>
    <link href="{{ asset('css/elfinder.theme.css')}}" rel='stylesheet'>
    <link href="{{ asset('css/jquery.iphone.toggle.css')}}" rel='stylesheet'>
    <link href="{{ asset('css/uploadify.css')}}" rel='stylesheet'>
    <link href="{{ asset('css/animate.min.css')}}" rel='stylesheet'>
    <!--link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet"-->
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
     <link rel="stylesheet" type="text/css" media="screen"
     href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
      <link rel="stylesheet" type="text/css" media="screen"
     href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css">
    
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
            <a class="navbar-brand" href="{{url('home')}}"> <img alt="Charisma Logo" src="{{asset('/img/logo20.png')}}" class="hidden-xs"/>
                <span>{{ config('app.name', 'Laravel') }}</span></a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> {{ Auth::user()->name }}</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                     @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                     @else
                            <!--li><a href="#"></a></li>
                            <li class="divider"></li-->
                            <li>  <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                            </li>
                            
                    @endguest
                </ul>
            </div>
            <!-- user dropdown ends -->

            <!-- theme selector starts -->
            <!--div class="btn-group pull-right theme-container animated tada">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-tint"></i><span
                        class="hidden-sm hidden-xs"> Change Theme / Skin</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="themes">
                    <li><a data-value="classic" href="#"><i class="whitespace"></i> Classic</a></li>
                    <li><a data-value="cerulean" href="#"><i class="whitespace"></i> Cerulean</a></li>
                    <li><a data-value="cyborg" href="#"><i class="whitespace"></i> Cyborg</a></li>
                    <li><a data-value="simplex" href="#"><i class="whitespace"></i> Simplex</a></li>
                    <li><a data-value="darkly" href="#"><i class="whitespace"></i> Darkly</a></li>
                    <li><a data-value="lumen" href="#"><i class="whitespace"></i> Lumen</a></li>
                    <li><a data-value="slate" href="#"><i class="whitespace"></i> Slate</a></li>
                    <li><a data-value="spacelab" href="#"><i class="whitespace"></i> Spacelab</a></li>
                    <li><a data-value="united" href="#"><i class="whitespace"></i> United</a></li>
                </ul>
            </div -->
            <!-- theme selector ends -->

            <!--ul class="collapse navbar-collapse nav navbar-nav top-menu">
                <li><a href="#"><i class="glyphicon glyphicon-globe"></i> Visit Site</a></li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"><i class="glyphicon glyphicon-star"></i> Dropdown <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
                <li>
                    <form class="navbar-search pull-left">
                        <input placeholder="Search" class="search-query form-control col-md-10" name="query"
                               type="text">
                    </form>
                </li>
            </ul-->

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
                        <!--li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> 数据字典管理</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="{{ url('/constantCategory') }}">数据字典管理</a></li>
                                <li><a href="{{ url('/courseCategory') }}">课程类别管理</a></li>
                                <li><a href="{{ url('/paymentCategory') }}">交费类别管理</a></li>
                            </ul>
                        </li-->
                        @can('view',App\Model\Role::class)
                        <li><a class="ajax-link" href="{{ url('/constantName') }}"><i class="glyphicon glyphicon-plus"></i><span> 数据字典管理</span></a>
                        </li>
                       
                        <!--li><a class="ajax-link" href="{{ url('/plan') }}"><i class="glyphicon glyphicon-home"></i><span> 班级管理</span></a>
                        </li-->
                        
                         <!--li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> 班级管理</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="{{ url('/plan') }}">班级管理</a></li>
                                <li><a href="{{ url('/') }}">统计管理</a></li>
                                <li><a href="{{ url('/') }}">管理</a></li>
                            </ul>
                        </li-->
                        <li><a class="ajax-link" href="{{ url('/student') }}"><i class="glyphicon glyphicon-list-alt"></i><span> 学生管理</span></a>
                        <li><a class="ajax-link" href="{{ url('/course') }}"><i class="glyphicon glyphicon-edit"></i><span> 课程管理</span></a></li>
                         @endcan
                        <li><a class="ajax-link" href="{{ url('/class') }}"><i class="glyphicon glyphicon-edit"></i><span> 班级管理</span></a></li>
                         @can('view',App\Model\Role::class)
                        <li><a class="ajax-link" href="{{ url('/classroom') }}"><i class="glyphicon glyphicon-eye-open"></i><span>教室管理</span></a></li>
                        
                        <li><a class="ajax-link" href="{{ url('/teacher') }}"><i class="glyphicon glyphicon-font"></i><span>教师管理</span></a>
                        </li>
                        <!--li><a class="ajax-link" href="{{ url('/user') }}"><i class="glyphicon glyphicon-picture"></i><span>用户管理</span></a>
                        </li-->
                       
                          <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> 财务管理</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="{{ url('/spend') }}">支出管理</a></li>
                                <li><a href="{{ url('/income') }}">收入管理</a></li>
                                <li><a href="{{ url('/monthList') }}">报表</a></li>
                            </ul>
                        </li>
                        @endcan
                        <!--li><a class="ajax-link" href="{{ url('/finance') }}"><i class="glyphicon glyphicon-align-justify"></i><span> 财务管理</span></a></li-->
                        
                        <!--li class="nav-header hidden-md">Sample Section</li>
                        
                        <li><a class="ajax-link" href="calendar.html"><i class="glyphicon glyphicon-calendar"></i><span> Calendar</span></a>
                        </li>
                        <li><a class="ajax-link" href="grid.html"><i
                                    class="glyphicon glyphicon-th"></i><span> Grid</span></a></li>
                        <li><a href="tour.html"><i class="glyphicon glyphicon-globe"></i><span> Tour</span></a></li>
                        <li><a class="ajax-link" href="icon.html"><i
                                    class="glyphicon glyphicon-star"></i><span> Icons</span></a></li>
                        <li><a href="error.html"><i class="glyphicon glyphicon-ban-circle"></i><span> Error Page</span></a>
                        </li>
                        <li><a href="login.html"><i class="glyphicon glyphicon-lock"></i><span> Login Page</span></a>
                        </li-->
                    </ul>
       
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
        @yield('content')
        </div>
    </div>
      <hr>
    <footer class="row">
        <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy; <a href="#" target="_blank">普瑞教育</a>2018</p>

        <p class="col-md-3 col-sm-3 col-xs-12 powered-by">Powered by: <a
                href="#">普瑞教育</a></p>
    </footer>
</div>
    <!-- Scripts -->
    <!--script src="{{ asset('js/app.js') }}"></script-->
    <script src="{{ asset('bower_components/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
   
    <!-- library for cookie management -->
    <script src="{{ asset('js/jquery.cookie.js') }}"></script>
    
    <!-- calender plugin -->
    <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
    
    <script src="{{ asset('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    
    <!-- data table plugin -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

    <!-- select or dropdown enhancer -->
    <script src="{{ asset('bower_components/chosen/chosen.jquery.min.js') }}"></script>
    
    <!-- plugin for gallery image view -->
    <script src="{{ asset('bower_components/colorbox/jquery.colorbox-min.js') }}"></script>
    
    <!-- notification plugin -->
    <script src="{{ asset('js/jquery.noty.js') }}"></script>
    
    <!-- library for making tables responsive -->
    <script src="{{ asset('bower_components/responsive-tables/responsive-tables.js') }}"></script>
   
    <!-- tour plugin -->
    <script src="{{ asset('bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js') }}"></script>
    
    <!-- star rating plugin -->
    <script src="{{ asset('js/jquery.raty.min.js') }}"></script>
    
    <!-- for iOS style toggle switch -->
    <script src="{{ asset('js/jquery.iphone.toggle.js') }}"></script>
    
    <!-- autogrowing textarea plugin -->
    <script src="{{ asset('js/jquery.autogrow-textarea.js') }}"></script>
   
    <!-- multiple file upload plugin -->
    <script src="{{ asset('js/jquery.uploadify-3.1.min.js') }}"></script>
    
    <!-- history.js for cross-browser state change on ajax -->
    <script src="{{ asset('js/jquery.history.js') }}"></script>
    
    <!-- application script for Charisma demo -->
    <script src="{{ asset('js/charisma.js') }}"></script>
    
    <script src="{{ asset('js/course.js') }}"></script>
    
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>
     <script type="text/javascript"
     src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js">
    </script>
   
<script type="text/javascript">
      $('#datetimepicker').datetimepicker({
        format: 'yyyy-MM-dd',
        language: 'CH',
        pickTime: false
      });
    </script>
</body>
</html>
