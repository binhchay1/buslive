<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | BusLive</title>

  <!-- Core Css -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
  <link rel="stylesheet" href="{{ URL::to('plugins/fontawesome-free/css/all.min.css') }}" />
  <link rel="stylesheet" href="{{ URL::to('css/admin/adminlte.min.css') }}" />
  <link rel="icon" href="{{ URL::to('img/icon.png') }}">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <!-- /Core Css -->

  <!-- Core JS -->
  <script src="{{ URL::to('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ URL::to('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ URL::to('plugins/chart.js/Chart.min.js') }}"></script>
  <script src="{{ URL::to('js/admin/adminlte.min.js') }}"></script>
  <script src="{{ URL::to('plugins/angular/js/angularjs.min.js') }}"></script>
  <!-- /Core JS -->

  <!-- Page JS -->
  <script src="{{ URL::to('/js/admin/main.js') }}"></script>
  <script src="{{ mix('js/app.js') }}" defer></script>
  <!-- /Page JS -->

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <div class="user-panel d-flex">
            <div class="image">
              @if(Auth::user()->profile_photo_path)
              <img src="{{ URL::to(Auth::user()->profile_photo_path) }}" class="img-circle elevation-2" height="50" />
              @else
              <img src="{{ URL::to('/img/default_avatar.png') }}" class="img-circle elevation-2" height="50" />
              @endif
            </div>
            <div class="info">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/admin/profile">Profile</a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="dropdown-item">{{ __('Sign out') }}</button>
            </form>
          </div>
        </li>
  </div>
  </div>
  </li>
  </ul>
  </nav>
  </div>
  @if (session('status'))
  <div class="alert alert-success clearfix" role="alert" id="alert-message">
    {{ session('status') }}
  </div>
  @endif

  @if($errors->any())
  {!! implode('', $errors->all('<div class="alert alert-success clearfix" role="alert" id="alert-message">:message</div>')) !!}
  @endif

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link">
      <img src="{{ URL::to('img/icon.png') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">BusLive</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar mt-2">
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="/admin/dashboard" class="nav-link" id="dashboard">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          @if(Auth::user()->role <= 2) <li class="nav-item menu-open">
            <a href="/admin/employee" class="nav-link" id="employee">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Employee
              </p>
            </a>
            </li>
            @endif

            @if(Auth::user()->role <= 2) <li class="nav-item menu-open">
              <a href="/admin/garages" class="nav-link" id="garages">
                <i class="nav-icon fas fa-warehouse"></i>
                <p>
                  Garages
                </p>
              </a>
              </li>
              @endif

              @if(Auth::user()->role <= 2) <li class="nav-item menu-open">
                <a href="/admin/bus" class="nav-link" id="bus">
                  <i class="nav-icon fas fa-car-side"></i>
                  <p>
                    Bus
                  </p>
                </a>
                </li>
                @endif

                @if(Auth::user()->role <= 2) <li class="nav-item menu-open">
                  <a href="/admin/roads" class="nav-link" id="roads">
                    <i class="nav-icon fas fa-road"></i>
                    <p>
                      Roads
                    </p>
                  </a>
                  </li>
                  @endif

                  @if(Auth::user()->role <= 2) <li class="nav-item menu-open">
                    <a href="/admin/station" class="nav-link" id="station">
                      <i class="nav-icon fas fa-parking"></i>
                      <p>
                        Station
                      </p>
                    </a>
                    </li>
                    @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Page content -->
  <div class="content-wrapper">
    <!-- Header content-->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 id="nameHeader"></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active" id="nameMenu"></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /Header content-->

    <div class="content">
      @yield('content')
    </div>
  </div>
  <!-- /Page content -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="/admin/dashboard/">BusLive</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
  <!-- /Main Footer -->

  </div>
</body>
<style>
  #alert-message {
    width: 20%;
    display: block;
    position: absolute;
    top: 50;
    right: 0;
    margin-top: 5px;
  }
</style>

</html>