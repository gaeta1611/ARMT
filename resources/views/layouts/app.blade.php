<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="{{ config('app.author') }}">

    <title>{{ config('app.name') }} :: @yield('title')</title>

   <!-- Bootstrap Core CSS -->
   <link href="{{ asset('../vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
   
    <!-- MetisMenu CSS -->
    <link href="{{ asset('../vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
   
    <!-- SB Admin CSS -->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sbadmin2-sidebar-toggle.css') }}" rel="stylesheet" type="text/css">

    <!-- Bootstrap Language selector CSS -->
    <link href="{{ asset('../vendor/bootstrap-select/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{ asset('../vendor/components/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <!--<link href="{{ asset('../vendor/morrisjs/morris.css')}}" rel="stylesheet">-->

    <!-- Custom Fonts -->
    <link href="{{ asset('../vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @section('css')
    @show

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">{{ Html::image('img/logo_adva.jpg','ARMT',[
                    'width'=>'150',
                    'heigth'=>'30'
                     ]) }}</a>
            </div>
            <!-- /.navbar-header -->

            
            
            <ul class="nav navbar-top-links navbar-right"> 
                <li class="dropdown">
                   <select class="selectpicker" data-width="fit">
                   <option lang="en" {{ (session()->has('lang') && session('lang')=='en') ? 'selected' : ''}} 
                        data-content='<span class="flag-icon flag-icon-us"></span> English'>English</option>
                   <option  lang="nl" {{ (session()->has('lang') && session('lang')=='nl') ? 'selected' : ''}}
                        data-content='<span class="flag-icon flag-icon-nl"></span> Nederlands'>Nederlands</option>
                   <option  lang="fr" {{ (session()->has('lang') && session('lang')=='fr') ? 'selected' : ''}}
                        data-content='<span class="flag-icon flag-icon-fr"></span> Français'>Français</option>
                   </select> 
                </li>
            @if(auth()->user())
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="user-login"><em>{{ auth()->user()->login}}</em></li>
                        <li><a href="{{ route('users.show',auth()->user()->id) }}"><i class="fa fa-user fa-fw"></i> {{ __('general.user_profile') }}</a></li>
                        <!-- <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>-->
                        <li class="divider"></li>
                        <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> {{ __('general.logout') }}</a>
                            <form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            @endif
            </ul>
            <!-- /.navbar-top-links -->
            <div id="sidebar-wrapper">
                @include('includes.sidebar')
            </div>
        </nav>

        <div id="page-wrapper">
            @include('includes.messages')

            @yield('content')
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('../vendor/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('../vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('../vendor/metisMenu/metisMenu.min.js') }}"></script>

    <!-- Morris Charts JavaScript -->
    <!-- 
    <script src="{{ asset('../vendor/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('../vendor/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('js/data/morris-data.js') }}"></script>
    -->

    <!-- SB Theme JavaScript -->
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>

    <!-- Bootstrap Language selector JavaScript -->
    <script src="{{ asset('../vendor/bootstrap-select/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

    <!-- Activate language selector-->
    <script>
        $(function(){
            const APP_URL = '{{ Config::get('app.url') }}';

            $('.selectpicker').selectpicker();

            $('.selectpicker').on('change',function() {
                var langue = $(this).find('option:selected').attr('lang');
                location.href = APP_URL+'/public/language/'+langue;
            });

            //Sidebard toggler
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                
                $("#wrapper").toggleClass("toggled");

                $('#wrapper.toggled').find("#sidebar-wrapper").find(".collapse").collapse('hide');
                
            });
        });
    </script>

    <!-- Custom Theme JavaScript -->
    @section('js')
    @show

</body>

</html>
