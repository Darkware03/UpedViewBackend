<!DOCTYPE html>
<html>
<head>
  <script src="{{ asset('js/app.js') }}" defer></script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>UpedView</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/adminlte/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/css/adminlte.min.css">
  <link rel="stylesheet" href="/adminlte/css/app.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/adminlte/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light"><!-- agregue este nav padre para envolver los navs en dos-->

      <div class="collapse navbar-collapse" id="navbarSupportedContent"><!-- encapsule todo dentro del div para evitar el problema d eherencia-->
        <!-- Left navbar links -->
        <ul class="navbar-nav mr-auto"><!-- Agregue una lista con la clas MR-auto para ponerlo a la izquierda siempre dentro del nav -->
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="" class="nav-link">Inicio</a>
          </li>
        </ul>


          <!-- AQUÍ AGREGUÉ LA PARTE DE AUTENTICACIÓN -->
          <ul class="navbar-nav ml-auto"><!-- Agregue una lista con la clas ML-auto para ponerlo a derecha -->
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endif
            @else
            <li class="nav-item">
              <a  class="nav-link " href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="fa fa-user" aria-hidden="true"></i>
                 {{ Auth::user()->name }} <span class="caret"></span>
              </a>


            </li>

            <li class="nav-item">
              <a class="nav-link text-danger" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out" aria-hidden="true"></i>
                   {{ __('Salir') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
          @endguest
          </ul>
        </div>

      <!-- AQUÍ TERMINA LA PARTE DE AUTENTICACIÓN-->


    <!-- SEARCH FORM -->

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="<?php echo asset('/logou.png')?>" alt="Logo" class="brand-image"
      style="opacity: .8">
      <span class="brand-text font-weight-light">UPEDView</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


      <!-- Sidebar Menu -->
      <nav class="mt-2">

      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Videos
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#/publicaciones" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Agregar Video</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#/categoriapublicacion" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Categorías de Video</p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="#/comentariopublicacion" class="nav-link">
              <i class="nav-icon far fa-circle text-success"></i>
              <p>Comentarios Vide</p>
            </a>
          </li> -->
        </ul>
      </li>
    </ul>
  </nav>

      <!--COMUNICADOS-->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-table"></i>
          <p>
            Comunicados
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#/comunicados" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Agregar Comunicado</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#/enterados" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Usuarios enterados</p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>

  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-bullhorn"></i>
      <p>
        Noticias
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#/noticias" class="nav-link">
          <i class="nav-icon far fa-circle text-info"></i>
          <p>Agregar Noticia</p>
        </a>
      </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#/categorianoticia" class="nav-link">
          <i class="nav-icon far fa-circle text-warning"></i>
          <p>Categorías de Noticias</p>
        </a>
      </li>
    </ul>
  </li>
</ul>
</nav>
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-share"></i>
      <p>
        Eventos
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#/eventos" class="nav-link">
          <i class="nav-icon far fa-circle text-info"></i>
          <p>Agregar Evento</p>
        </a>
      </li>
    </ul>
  </li>
</ul>
</nav>

  <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-book"></i>
          <p>
            Generalidades
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#/estados" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Datos Generales</p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
          <li class="nav-item">
            <a href="#/areas" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
               Carreras
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-images"></i>
              <p>
                Galeria de Fotos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#/galeria_fotos" class="nav-link">
                  <i class="nav-icon far fa-image text-success"></i>
                  <p>Agregar Fotos</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#/album" class="nav-link">
                  <i class="nav-icon far fa-images text-success"></i>
                  <p>Agregar Album</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav> -->
      <!-- <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
          <li class="nav-item">
            <a href="#/Linksinteres" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
               Links de Interés
              </p>
            </a>
          </li>
        </ul>
      </nav> -->


    <!-- Opcion de Correos personaless en el nav izquierdo -->

    <!-- <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-poll"></i>
            <p>
              Correos Personales
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#/correopersonales" class="nav-link">
                <i class="nav-icon fas fa-poll text-warning"></i>
                <p>Correo Personal</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#/asuntos" class="nav-link">
                <i class="nav-icon fas fa-poll-h text-success"></i>
                <p>Asuntos</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>-->

     <!-- Opcion de Correos personaless en el nav izquierdo -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
          <li class="nav-item has-treeview">
            <a href="#/sugerencias" class="nav-link">
              <i class="nav-icon fas fa-newspaper" aria-hidden="true"></i>
              <p>
                Sugerencias
              </p>
            </a>
          </li>
        </ul>
     </nav>

      <!-- Opcion de Solicitudes de Vacaciones en el nav izquierdo -->
    <!-- <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
          <li class="nav-item has-treeview">
            <a href="#/solicitudesvacaciones" class="nav-link">
              <i class="nav-icon fas fa-plane" aria-hidden="true"></i>
              <p>
                Solicitudes de Vacaciones
              </p>
            </a>
          </li>
        </ul>
     </nav> -->

     <!-- <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-poll"></i>
            <p>
              Encuestas
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#/sondeos" class="nav-link">
                <i class="nav-icon fas fa-poll text-warning"></i>
                <p>Encuestas activas</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#/nuevo_sondeo" class="nav-link">
                <i class="nav-icon fas fa-poll-h text-success"></i>
                <p>Agregar Encuesta</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav> -->

    <!-- <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-poll"></i>
            <p>
              Opiniones
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#/encuestas" class="nav-link">
                <i class="nav-icon fas fa-poll text-warning"></i>
                <p>Opiniones activas</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#/nuevaencuesta" class="nav-link">
                <i class="nav-icon fas fa-poll-h text-success"></i>
                <p>Agregar Opiniones</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>-->
      <!-- Opcion de Usuarios en el nav izquierdo -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuarios
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#/Usuarios" class="nav-link">
                  <i class="nav-icon fas fa-user-plus text-success"></i>
                  <p>Agregar Usuarios</p>
                </a>
              </li>
            </ul>
            <!--<ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#/Cargos" class="nav-link">
                  <i class="nav-icon fas fa-user-plus text-success"></i>
                  <p>Agregar Cargos</p>
                </a>
              </li>
            </ul>-->
          </li>
        </ul>
     </nav>
      <!-- Opcion de Solicitudes de Vacaciones en el nav izquierdo -->
    <!-- <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
          <li class="nav-item has-treeview">
            <a href="#/entradasalida" class="nav-link">
              <i class="nav-icon fas fa-check-square" aria-hidden="true"></i>
              <p>
                Registros Entrada-Salida
              </p>
            </a>
          </li>
        </ul>
     </nav> -->



      <!-- /.sidebar-menu -->
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

      <div class="card-body">
        <div id="app">
            @yield('content')
        </div>
      </div>

    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020-2022 <a href="https://www.facebook.com/geovany.guzman.904/">Dev GGuzman</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.x
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/adminlte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/adminlte/plugins/moment/moment.min.js"></script>
<script src="/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/adminlte/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/adminlte/js/demo.js"></script>
</body>
</html>
