<header class="fixed-top"> 
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            @if(Request::is('owner*'))
            <a class="navbar-brand" href="{{ url('/owner') }}">
            @elseif(Request::is('admin*'))
            <a class="navbar-brand" href="{{ url('/admin') }}">
            @elseif(Request::is('user*'))
            <a class="navbar-brand" href="{{ url('/user') }}">
            @else
            <a class="navbar-brand" href="{{ url('/') }}">
            @endif
                レストラン
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @if(!Auth::check() && (!isset($authgroup) || !Auth::guard($authgroup)->check()))
                        @if((Request::is('login*') || Request::is('register*')) && !Request::is('*admin'))
                            <li class="nav-item">
                                @isset($authgroup)
                                <a class="nav-link" href="{{ url("login/$authgroup") }}">{{ __('Login') }}</a>
                                @else
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @endisset
                            </li>
                            <li class="nav-item">
                                @isset($authgroup)
                                <a class="nav-link" href="{{ url("register/$authgroup") }}">{{ __('Register') }}</a>
                                @else
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endisset
                            </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                MENU
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('login') }}">ユーザーログイン</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('register') }}">ユーザー新規登録</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('login/owner') }}">オーナーログイン</a>
                            </div>
                        </li>
                        @endif
                        
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                
                                @if(Request::is('owner*'))
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('owner.mypage') }}">オーナーマイページ</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('owner.create') }}">店舗登録</a>
                                @elseif(Request::is('user*'))
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('user.mypage') }}">ユーザーマイページ</a>
                                @elseif(Request::is('admin*'))
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('genres.index') }}">ジャンル管理ページ</a>
                                @endif
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header> 