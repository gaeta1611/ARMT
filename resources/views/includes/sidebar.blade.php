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
                            <a href="{{ route('home') }}"><i class="fa fa-dashboard fa-fw"></i> {{__('general.home')}}</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-briefcase fa-fw"></i> {{ucfirst(trans_choice('general.client',2))}} &amp; {{ucfirst(trans_choice('general.prospect',2))}}<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('clients.index',['prospect'=>false]) }}">{{__('general.search')}} <i class="fa fa-search"></i></a>
                                </li>
                                <li>
                                    <a href="{{ route('clients.create')}}">{{__('general.add')}} <i class="fa fa-plus-circle"></i></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> {{ucfirst(trans_choice('general.candidate',2))}}<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('candidats.index')}}">{{__('general.search')}} <i class="fa fa-search"></i></a>
                                </li>
                                <li>
                                    <a href="{{ route('candidats.create')}}">{{__('general.add')}} <i class="fa fa-plus-circle"></i></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <li>
                            <a href="{{ route('missions.index',['filter'=>'Statut=En cours']) }}"><i class="fa fa-code-fork fa-fw"></i> {{ucfirst(trans_choice('general.mission',2))}}</a>
                        </li>
                    @if(in_array('admin',auth()->user() ? auth()->user()->roles()->select('name')->get()->toArray()[0]:[]))
                        <li>
                            <a href="#"><i class="fa fa-users"></i> {{ucfirst(trans_choice('general.user',2))}}<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('users.index')}}">{{__('general.list')}} <i class="fa fa-search"></i></a>
                                </li>
                                <li>
                                    <a href="{{ route('register')}}">{{__('general.add')}} <i class="fa fa-plus-circle"></i></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    @endif
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