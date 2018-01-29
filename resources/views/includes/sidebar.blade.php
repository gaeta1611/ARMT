<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="{{ route('clients.index') }}"><i class="fa fa-dashboard fa-fw"></i> Accueil</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-briefcase fa-fw"></i> Clients<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('clients.index',['prospect'=>false]) }}">Rechercher <i class="fa fa-search"></i></a>
                                </li>
                                <li>
                                    <a href="{{ route('clients.create')}}">Ajouter <i class="fa fa-plus-circle"></i></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Candidats<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('candidats.index')}}">Rechercher <i class="fa fa-search"></i></a>
                                </li>
                                <li>
                                    <a href="{{ route('candidats.create')}}">Ajouter <i class="fa fa-plus-circle"></i></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-eur fa-fw"></i> Prospects<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('clients.index',['prospect'=>true]) }}">Rechercher <i class="fa fa-search"></i></a>
                                </li>
                                <li>
                                    <a href="{{ route('clients.create')}}">Ajouter <i class="fa fa-plus-circle"></i></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="{{ route('missions.index',['filter'=>'Statut=En cours']) }}"><i class="fa fa-code-fork fa-fw"></i> Missions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" id="sidenavToggler" color="dark">
                                <i class="fa fa-fw fa-angle-left"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->