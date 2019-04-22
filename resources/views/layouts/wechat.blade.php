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
           
                <a class="navbar-brand"> <img alt="Logo" src="{{asset('/img/logo20.png')}}" class=""/>
                    </a>
                <p class="pull-right navbar-brand">{{Auth::user()==null?'':'你好！'.Auth::user()->name }}</p>
            </div>
        </div>
        <!-- topbar ends -->

        <div class="ch-container">
            <div class="row">

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
