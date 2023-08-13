<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="{{ route('news.index') }}">LKS Jabar 2023 News</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navigation">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @if ($isLogin)
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('news.create') }}">Add News</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('auth.logout') }}">Logout</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('auth.login') }}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('auth.register') }}">Register</a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
