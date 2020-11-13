<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars"></i></a>
    <a class="navbar-brand" href="{!! route('home') !!}">Canadian Electronic Store</a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                @if(isAuth())
                    <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> {!! authDetail() !!}
                    </a>
                @endif
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    {{--<a href="#" class="dropdown-item">Profile</a>--}}
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>