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
    <link href="{{ asset('../vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('../vendor/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

    <!-- SB admin CSS -->
    <link href="{{ asset('css/sb-admin-2.css')}}" rel="stylesheet">

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
            @if(auth()->user())
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="user-login"><em>{{ auth()->user()->login}}</em></li>
                        <li><a href="{{ route('users.show',auth()->user()->id) }}"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                        <!-- <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>-->
                        <li class="divider"></li>
                        <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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

            @section('sidebar')
            @show
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

    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>

    @section('js')
    @show


</body>

</html>
