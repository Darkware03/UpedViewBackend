<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>UPEDView | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page" style="background-color:#F1F1F1">
<div class="login-box">
  <div class="login-logo">
    <!--<a href="/" style="color: white"><b>Ci2 </b>R.H</a>-->
    <a href="/" style="color: white">
        <img src="<?php echo asset('/logou.png')?>" style="max-width:300px">
    </a>
      <?php //echo asset('/logo1.png') ?>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicie sesión por favor:</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group @error('email') is-invalid @enderror mb-3">
          <input type="email"
                 class="form-control border-warning"
                 placeholder="Email"
                 name="email"
                 value="{{ old('email') }}"
                 required autocomplete="email" autofocus>
            @error('email')
             <span class="invalid-feedback" role="alert" >
                <strong>{{ $message }}</strong>
             </span>
            @enderror
          <div class="input-group-append ">
            <div class="input-group-text border-warning">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group @error('password') is-invalid @enderror mb-3">
          <input type="password"
                class="form-control border-warning"
                placeholder="Contraseña"
                name="password"
                required autocomplete="current-password">

          @error('password')
             <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
             </span>
            @enderror
          <div class="input-group-append">
            <div class="input-group-text border-warning">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
         <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
                Recordar Sesión
              </label>
            </div>
          </div>-->
          <!-- /.col -->
          <div class="col-12">
              <center>
                  <button type="submit" class="btn btn-block btn-outline-warning" >Acceder</button>

              </center>
          </div>
          <!-- /.col -->
        </div>
      </form>

      @if (isset($errors) && count($errors))

        There were {{count($errors->all())}} Error(s)
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }} </li>
          @endforeach
        </ul>

      @endif

    <!--  <p class="mb-1">
        <a href="{{ route('register') }}">¿No tiene cuenta?</a>
      </p>-->

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>

</body>
</html>








