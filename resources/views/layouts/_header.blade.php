<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
      <!-- Branding Image -->
      <a class="navbar-brand " href="{{ url('/') }}">
        Zhihu
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item"><a class="nav-link" href="/questions">发现</a></li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav navbar-right">
          <!-- Authentication Links -->
          @guest
            <li class="nav-item"><a class="btn-sm btn btn-outline-primary fs-09" href="{{ route('login') }}">登录</a></li>
            <li class="nav-item"><a class="ml-3 btn-sm btn btn-primary fs-09" href="{{ route('register') }}">加入知乎</a></li>
          @else
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">个人中心</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" id="logout" href="#">
                  <form action="{{ route('logout') }}" method="POST">
                    {{ csrf_field() }}
                    <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                  </form>
                </a>
              </div>
            </li>
          @endguest
        </ul>
      </div>
  </div>
</nav>
