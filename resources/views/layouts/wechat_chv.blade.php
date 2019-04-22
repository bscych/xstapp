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
                <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy; <a href="#" target="_blank">普瑞教育</a>2018-2019</p>

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
