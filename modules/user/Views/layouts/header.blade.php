<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        {{--<span>
            User System
        </span>--}}
        {{--<img src="{{ URL::to('/') }}/assets/img/logo22.png" alt="bZm Graphics" class="bgm_logo_img">--}}
        <h5>Administrator Panel</h5>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary"></span>
        </div>
        <form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
                {{--<input type="text" placeholder="Search something special" class="form-control" name="search">--}}
            </div>
        </form>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown">
                    {{--<a href="{{Route('get-user-login')}}">
                        <i class="pe-7s-upload pe-rotate-90"></i>
                    </a>--}}

                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small style="font-size: small">{{isset(Auth::user()->username)?ucfirst(Auth::user()->username):''}}<b class="caret"></b></small>
                    </a>

                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{Route('user-profile')}}">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="{{Route('user-logout')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>