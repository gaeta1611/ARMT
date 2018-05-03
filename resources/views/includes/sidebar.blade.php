<div class="navbar-default sidebar" role="navigation">
<div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
        <li>
            <a href="{{ route('missions.index',['filter'=>'Statut=En cours']) }}"><i class="fa fa-code-fork fa-fw"></i>
                <span class="masked">{{ ucfirst(trans_choice('general.mission',10)) }}</span>
            </a>
        </li>
        <li>
            <a href="#"><i class="fa fa-briefcase fa-fw"></i>
                <span class="masked">{{ ucfirst(trans_choice('general.client',10)) }} &amp; {{ ucfirst(trans_choice('general.prospect',10)) }}<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('clients.index') }}">{{ __('general.search') }} <i class="fa fa-search fa-fw"></i></a>
                </li>
                <li>
                    <a href="{{ route('clients.create') }}">{{ __('general.add') }} <i class="fa fa-plus-circle fa-fw"></i></a>
                </li>
            </ul>
            <!--/.nav-second-level--> 
        </li>
        <li>
            <a href="#"><i class="fa fa-user fa-fw"></i>
                <span class="masked">
                    {{ ucfirst(trans_choice('general.candidate',10)) }}<span class="fa arrow"></span>
                </span>
            </a>
            <ul class="nav nav-second-level collapse">
                <li>
                    <a href="{{ route('candidats.index') }}">{{ __('general.search') }}  <i class="fa fa-search fa-fw"></i></a>
                </li>
                <li>
                    <a href="{{ route('candidats.create') }}">{{ __('general.add') }}  <i class="fa fa-plus-circle fa-fw"></i></a>
                </li>
            </ul>
            <!-- /.nav-second-level --> 
        </li>
    @if(in_array('admin',auth()->user() ? auth()->user()->roles()->select('name')->get()->toArray()[0]:[]))
        <li>
            <a href="#"><i class="fa fa-users"></i>
                <span class="masked">{{ ucfirst(trans_choice('general.user',10)) }}<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('users.index') }}">{{ __('general.list') }} <i class="fa fa-search fa-fw"></i></a>
                </li>
                <li>
                    <a href="{{ route('register') }}">{{ __('general.add') }} <i class="fa fa-plus-circle fa-fw"></i></a>
                </li>
            </ul>
           <!-- /.nav-second-level --> 
        </li>
    @endif
    </ul>
    <ul style="margin: 5px 0;padding:0;text-align: center">
        <li style="list-style-type: none;">
           <button style="width:100%; margin: 5px 0; border:none" id="menu-toggle" type="button" data-toggle="button" class="btn btn-default btn-xs">
               <i class="fa fa-exchange fa-fw"></i>
           </button>
       </li>
    </ul>
</div>
 <!-- /.sidebar-collapse --> 
</div>
<!-- /.navbar-static-side --> 