@if (Auth::check())
    @if (Auth::user()->level == 'admin')
    <script>window.location = "{{ route('indexadmin') }}";</script>
    @elseif (Auth::user()->level == 'karyawan')
    <script>window.location = "{{ route('indexkaryawan') }}";</script>
    @endif
@endif
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Pembayaran Sekolah</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ url('/') }}" class="h1"><b>SPP.</b>Kita</a>
    </div>
    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('status') }}
          </div>
    @endif
    @if (session('sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('sukses') }}
          </div>
    @endif
    @if (session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-times"></i> Gagal!</h5>
            {{ session('gagal') }}
          </div>
    @endif

      <form action="{{ route('ceknis') }}" method="post">
        @csrf
        <div class="form-group">
        <label for="">Cek Pembayaran</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Masukan NIS" name="nis">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        </div>
        <div class="form-group">
        <label for="">Tanggal lahir (Format: 021120)</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Masukan Tanggal Lahir" name="tgl_lahir">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        </div>
        <div class="row justify-content-center">

          <!-- /.col -->
          <div class="col-6">
            <a href="" id="reset" class="btn btn-danger btn-block" onclick="return false">Reset</a>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Cek</button>
          </div>
          </form>

          <!-- /.col -->
        </div>
        <div class="mt-3"><a href="{{route('index')}}">Login Petugas</a></div>


    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('adminv') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminv') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminv') }}/dist/js/adminlte.min.js"></script>
<script>
   $("#reset").click(function(){
  $('input').val('')
});
</script>
</body>
</html>
