<div id="navigation">
    <div class="profile-picture">

        <div class="stats-label text-color">
            <span class="font-extra-bold font-uppercase">{{isset(Auth::user()->username)?ucfirst(Auth::user()->username):''}}</span>

            <div class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown"><b class="caret"></b>
                    {{--<small class="text-muted">Founder of App <b class="caret"></b></small>--}}
                </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <li><a href="{{Route('user-profile')}}">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="{{Route('user-logout')}}">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <ul class="nav" id="side-menu">
        @if(\Illuminate\Support\Facades\Session::has('sidebar_menu_user'))
            <?php $side_bar_menu = \Illuminate\Support\Facades\Session::get('sidebar_menu_user'); ?>

            @if($side_bar_menu) {{--Session['sidebar_menu_user']--}}
            @foreach($side_bar_menu as $module) {{--Every module on sidebar menu--}}
            @if(count($module['sub-menu'])>0) {{--Session['sidebar_menu_user']--}}
            @foreach($module['sub-menu'] as $sub_module) {{--Sub menu on every module--}}
            <li>
                <a tabindex="-1" href="{{URL::to($sub_module['route'])}}">
                    <i class="{{@$sub_module['icon_code']}}"> </i>
                    <span class="mm-text">{{$sub_module['menu_name']}}</span>
                </a>
                @if(count($sub_module['sub-menu'])>0)
                    <ul class="nav nav-second-level collapse">
                        @foreach($sub_module['sub-menu'] as $sub_sub_module)
                            <li>
                                <a tabindex="-1" href="{{URL::to($sub_sub_module['route'])}}">
                                    <i class="{{@$sub_sub_module['icon_code']}}"> </i>
                                    <span class="mm-text">{{$sub_sub_module['menu_name']}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>

            @endforeach
            @endif
            @endforeach
            @endif
        @endif

    </ul>
</div>