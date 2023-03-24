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
<body>
    <div class="row justify-content-center mt-5">
        <div class="col-4">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ url('/') }}" class="h1"><b>Data </b>Siswa</a>
    </div>
    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('status') }}
          </div>
    @endif
    <table class="table table-sm mb-3">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{$detail->nama}}</td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td>{{$detail->nis}}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{$detail->status == 'bs' ? 'Boarding' : 'Fullday'}}</td>
        </tr>
    </table>
    <label for="">3 Pembayaran Terakhir</label>
        <table class="table table-sm table-striped table-bordered mb-3">
            <tr>
                <th>Bulan</th>
                <th>Tgl Bayar</th>
            </tr>
            @foreach ($data as $d)
                <tr>
                    <td>{{$d->bulan}} {{$d->tahun}}</td>
                    <td>{{date('d F Y', strtotime($d->created_at))}}</td>
                </tr>
            @endforeach
        </table>
        </div>



    </div>
    <!-- /.card-body -->
  </div>
  <div class="col-lg-3">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="{{ url('/') }}" class="h1"><b>Bayar </b>SPP</a>
        </div>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                {{ session('status') }}
              </div>
        @endif
        <form action="{{route('bayar')}}" method="post">
            @csrf
            <input type="text" value="{{$detail->nis}}" name="nis" hidden>
            <input type="text" value="{{$detail->status}}" name="status" hidden>
            <div class="form-group">
                <label for="">Bulan: </label>
                <select name="bulan" class="form-control" required>
                    <option value="">Pilih Bulan</option>
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                </select>
                <div class="text-danger">
                    @error('bulan')
                        {{$message}}
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="">Tahun</label>
                <select name="tahun" class="form-control" required>
                    <option value="">Pilih Tahun</option>
                    <option value="{{date('Y')-3}}">{{date('Y')-3}}</option>
                    <option value="{{date('Y')-2}}">{{date('Y')-2}}</option>
                    <option value="{{date('Y')-1}}">{{date('Y')-1}}</option>
                    <option value="{{date('Y')}}">{{date('Y')}}</option>
                    <option value="{{date('Y')+1}}">{{date('Y')+1}}</option>
                    <option value="{{date('Y')+2}}">{{date('Y')+2}}</option>
                </select>
                <div class="text-danger">
                    @error('tahun')
                        {{$message}}
                    @enderror
                </div>
              </div>
              
                
                <div class="row justify-content-center">
        
                 
                  <div class="col">
                    <button type="submit" class="btn btn-primary btn-block">Bayar</button>
                  </div>
                  </form>
            </div>
            <div class="mt-2"><i><strong>Note:</strong> Pilih Bulan dan Tahun yang belum dibayar!</i></div>
    
    
    
        </div>
        <!-- /.card-body -->
    

          <!-- /.col -->
  </div>
  <!-- /.card -->
</div>

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
