<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ci2 R.H | Registro</title>
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
  <body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>Ci2</b> R.H</a>
    </div>



    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Nuevo registro:</p>

        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="input-group mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
            name="name" value="{{ old('name') }}" required 
            autocomplete="name" 
            autofocus placeholder="Nombre">
            <div class="input-group-append">
              <div class="input-group-text">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
            name="email" 
            value="{{ old('email') }}" required 
            autocomplete="email" 
            placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
            name="password" 
            required autocomplete="new-password" 
            placeholder="Una contraseña de 8 caracteres o más">
            <div class="input-group-append">
              <div class="input-group-text">
                  @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                  @enderror
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input class="form-control" 
            type="password"
            id="password-confirm" 
            name="password_confirmation" 
            required autocomplete="new-password" 
            placeholder="Confirme Contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="login" class="text-center">¿Ya está registrado?</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->
  <!-- jQuery -->
  <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/adminlte/dist/js/adminlte.min.js"></script>
  </body>
  </html>









