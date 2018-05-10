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
                <a class="navbar-brand" href="{{ route('home') }}">{{ Html::image('img/logo_adva.jpg','ARMT',[
                    'width'=>'130',
                    'heigth'=>'30',
                     ]) }}
                </a>  
            </div>
            <!-- /.navbar-header -->
        @if(auth()->user())
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
            </ul>
            <form class="form-inline" id="frmSearchAll" autocomplete="off">
                    <div id="search-group">
                        <div class="input-group">
                            <input type="text" id="search" class="form-control" placeholder="Search...">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /input-group -->
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Liste
                            <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            </ul>
                        </div>
                    </div>
                    <!-- /search-group -->
                </form>
 
            <!-- /.navbar-top-links -->
            <div id="sidebar-wrapper">
                @include('includes.sidebar')
            </div>
        @endif
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

    <!-- SB Theme JavaScript -->
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>

    <!-- Bootstrap Language selector JavaScript -->
    <script src="{{ asset('../vendor/bootstrap-select/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

    <!-- Activate language selector-->
    <script>
        function fetchDataFromSearch(data, liste, apiURL) {       
            apiURL += 'search';

            return $.ajax({
                url:apiURL,
                method: 'GET',
                crossDomain: true,
                data: { keyword: data },
                dataType: 'json',
                headers: {'Authorization':'Bearer '+API_TOKEN},
                success: function(data){
                    $.each(data, function(key, value) {
                        liste[key] = value;
                    });
                },
            });
        }

        const APP_URL = '{{ Config::get('app.url') }}'; //console.log(APP_URL+ '/public/api/' + table);
        var armtAPI = APP_URL + '/public/api/';
        const API_TOKEN = '{{ Auth::user() ? Auth::user()->api_token : "" }}';

        $(function(){
            $('.selectpicker').selectpicker();

            $('.selectpicker').on('change',function() {
                var langue = $(this).find('option:selected').attr('lang');
                location.href = APP_URL+'/public/language/'+langue;
            });

            //Sidebar toggler
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                
                $("#wrapper").toggleClass("toggled");
                    
                if($("#wrapper").hasClass("toggled")) {
                    $('#wrapper').find("#sidebar-wrapper").find(".collapse").css('height','0px');
                    $('#wrapper').find("#sidebar-wrapper").find(".collapse").collapse('hide');
                    
                    setTimeout(function() { 
                        $('#menu-toggle').removeClass('active'); 
                        $('#menu-toggle').removeClass('focus'); 
                        $('#menu-toggle').blur(); 
                    },100);
                } else {
                    $('#wrapper').find("#sidebar-wrapper").find("a.active").parent().parent().collapse('show');
                    $('#wrapper').find("#sidebar-wrapper").find("a.active").parent().parent().show('fast', function() {
                        $(this).slideDown('slow');
                    });
                    
                    setTimeout(function() { 
                        $('#menu-toggle').removeClass('active'); 
                        $('#menu-toggle').removeClass('focus'); 
                        $('#menu-toggle').blur(); 
                    },100);

                }
                
            });
            
            //Ouvrir le menu fermé (toggled) pour afficher le sous-menu 
            $('.nav li').on('click', function() {
                if($("#wrapper").hasClass("toggled")) {
                    $("#menu-toggle").click();
                }
            });
        
            //Moteur de recherche général
            $("#frmSearchAll").submit(function(e) {
                e.preventDefault();
                
                return false;
            });
            
            //$('#search-group .dropdown button').hide();
            var $dropdownList = $('#search-group .dropdown ul.dropdown-menu');
            var $dropdownButton = $('#search-group .dropdown button');
            
            $('input#search').on('keyup', function(e) {
                if(e.keyCode!=13) {         console.log(e.keyCode);
                    if(e.keyCode==40) {
                        //Quitter la zone de texte et descendre dans la liste
                        $(this).blur();
                        $dropdownButton.click();
                        $dropdownList.focus();
                        
                        return false;
                    }
                    
                    //Actualiser la datalist
                    var search = this.value;// + (e.keyCode!=8 ? e.key : '');

                    if(search=='') {
                        $dropdownList.hide();
                    } else {
                        $dropdownList.show();
                    
                        var liste = [];

                        fetchDataFromSearch(search, liste, armtAPI).then(function(data) {
                            console.log(data.result);
                            var nbResults = data.result.candidats.length
                                + data.result.clients.length
                                + data.result.missions.length;
                            var height = '150px';
                            
                            $dropdownList.empty().css('height',height);



                            if(data.result.candidats.length) {
                                $dropdownList.append('<li role="separator"><strong>Candidats</strong></li>');
                                for(var i in data.result.candidats) {
                                    $dropdownList
                                        .append('<li><a href="'+APP_URL+'/public/candidats/'+data.result.candidats[i].id+'">'+data.result.candidats[i].prenom+' '+data.result.candidats[i].nom+'</a></li>');
                                }
                            }

                            if(data.result.clients.length) {
                                $dropdownList.append('<li role="separator"><strong>Clients</strong></li>');
                                for(var i in data.result.clients) {
                                    $dropdownList
                                        .append('<li><a href="'+APP_URL+'/public/clients/'+data.result.clients[i].id+'">'+data.result.clients[i].nom_entreprise
                                        +(data.result.clients[i].personne_contact ? ' ('+data.result.clients[i].personne_contact+')' : '')
                                        +'</a></li>');
                                }
                            }

                            if(data.result.missions.length) {
                                $dropdownList.append('<li role="separator"><strong>Missions</strong></li>');
                                for(var i in data.result.missions) {
                                    $dropdownList
                                        .append('<li><a href="'+APP_URL+'/public/missions/'+data.result.missions[i].id+'">'+data.result.missions[i].prefixed+'</a></li>');
                                }
                            }
                        });
                    }
                } else {
                    var search = this.value;

                    $link = $dropdownList.find('a').filter(function(i, link) {
                        return $(this).text().toLowerCase() == search.toLowerCase();
                    }).first();

                    //Afficher la fiche sélectionnée
                    if($link.length) {
                        location.href = $link.attr('href');
                    } else {
                        alert('Veuillez cliquer sur un élément de la liste ou taper le nom complet.');
                    }
                }
                
                e.preventDefault();
                return false;
            });
        });
    </script>

    <!-- Custom Theme JavaScript -->
    @section('js')
    @show

</body>

</html>
