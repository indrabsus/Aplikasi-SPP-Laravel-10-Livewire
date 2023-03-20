<div>
    @if(session('sukses'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fa fa-check"></i> Sukses!</h5>
    {{session('sukses')}}
    </div>
    @endif
    @if(session('gagal'))
    <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fa fa-times"></i> Gagal!</h5>
    {{session('gagal')}}
    </div>
    @endif
    <div class="row justify-content-between">
        <div class="col-lg-3">
            <a class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"> Tambah</i></a>
        </div>
        <div class="row justify-content-end">
            <div class="col-lg-3 mb-1">
                <select wire:model='result' class="form-control">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-lg-6 mb-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Nama" wire:model="cari">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                  </div>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Kelas</th>
            <th>Status</th>
            @if(Auth::user()->level == 'admin' || Auth::user()->level == 'petugas')
            <th>Wa Ortu</th>
            @endif
            <th>Aksi</th>
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nis }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->nama_kelas }}</td>
                <td>{{ $d->status == 'bs' ? 'Boarding' : 'Fullday' }}</td>
                @if(Auth::user()->level == 'admin' || Auth::user()->level == 'petugas')
                <td><a href="https://api.whatsapp.com/send?phone=62{{ substr($d->wa_ortu, 1) }}" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-whatsapp"></i> Whatsapp</a></td>
                @endif
                <td>@if(Auth::user()->level == 'admin' || Auth::user()->level == 'petugas')
                <a class="btn btn-dark btn-sm mb-1" data-toggle="modal" data-target="#k_bayar" wire:click="k_bayar({{ $d->nis }})"><i class="fa fa-child"></i> Bayar</a>
                    <a class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#edit" wire:click="edit({{ $d->nis }})"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->nis }})"><i class="fa fa-trash"></i></a>
                    <a class="btn btn-dark btn-sm mb-1" data-toggle="modal" data-target="#history" wire:click="history({{ $d->nis }})"><i class="fa fa-history"></i> History</a>
                    @endif
                    @if(Auth::user()->level == 'majelis' || Auth::user()->level == 'admin')
                    <a class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#req" wire:click="req({{ $d->nis }})"><i class="fa fa-share" aria-hidden="true"></i> Pengajuan</a>
                    @endif
                  </td>
            </tr>
        @endforeach
    </table>

            {{ $data->links() }}

    <div class="modal fade" id="add" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="">NIS</label>
                <input type="number" wire:model="nis" class="form-control">
                <div class="text-danger">
                    @error('nis')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Nama Lengkap</label>
                <input type="text" wire:model="nama" class="form-control">
                <div class="text-danger">
                    @error('nama')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Status</label>
                <select wire:model="status" class="form-control">
                    <option value="">Pilih status</option>
                    <option value="bs">Boarding</option>
                    <option value="fd">Fullday</option>
                </select>
                <div class="text-danger">
                    @error('status')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Kelas</label>
                <select wire:model="id_kelas" class="form-control">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                    <option value="{{$k->id_kelas}}">{{$k->nama_kelas}}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_kelas')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Wa Ortu</label>
                <input type="number" wire:model="wa_ortu" class="form-control">
                <div class="text-danger">
                    @error('wa_ortu')
                        {{$message}}
                    @enderror
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary suksestambah" wire:click="insert()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


    <div class="modal fade" id="edit" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="">NIS</label>
                  <input type="number" wire:model="nis" class="form-control">
                  <div class="text-danger">
                      @error('nis')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Nama Lengkap</label>
                  <input type="text" wire:model="nama" class="form-control">
                  <div class="text-danger">
                      @error('nama')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Status</label>
                  <select wire:model="status" class="form-control">
                      <option value="">Pilih status</option>
                      <option value="bs">Boarding</option>
                      <option value="fd">Fullday</option>
                  </select>
                  <div class="text-danger">
                      @error('status')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Kelas</label>
                  <select wire:model="id_kelas" class="form-control">
                      <option value="">Pilih Kelas</option>
                      @foreach ($kelas as $k)
                      <option value="{{$k->id_kelas}}">{{$k->nama_kelas}}</option>
                      @endforeach
                  </select>
                  <div class="text-danger">
                      @error('id_kelas')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                    <label for="">Wa Ortu</label>
                    <input type="number" wire:model="wa_ortu" class="form-control">
                    <div class="text-danger">
                        @error('wa_ortu')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
              </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="update()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <div class="modal fade" id="k_hapus" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                Apakah Kamu yakin menghapus data ini?

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="delete()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <div class="modal fade" id="k_bayar" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Bayar SPP</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
               <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="">NIS</label>
                    <input type="number" wire:model="nis" class="form-control" readonly>
                    <div class="text-danger">
                        @error('nis')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="">Status</label>
                    <input type="text" value="{{$status == 'fd' ? 'Fullday' : 'Boarding'}}" class="form-control" readonly>
                    <div class="text-danger">
                        @error('status')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                </div>
               </div>
                <div class="form-group">
                  <label for="">Bulan</label>
                  <select wire:model="bulan" class="form-control">
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
                  <select wire:model="tahun" class="form-control">
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
                <div class="form-group">
                    <label for="">SPP</label>
                    <select class="form-control" wire:model="switch">
                        <option value="">Pilih Biaya SPP</option>
                        <option value="o">Otomatis</option>
                        <option value="m">Manual</option>
                    </select>
                    @if ($switch == 'o')
                    <div class="row mt-2">
                      <div class="col">
                        <label for="">Uang SPP</label>
                        <input type="text" class="form-control" value='Rp.500.000' readonly>
                      </div>
                      <div class="col">
                        <label for="">Makan</label>
                        <input type="text" class="form-control" value='{{$status == 'fd' ? 'Rp.200.000' : 'Rp.375.000'}}' readonly>
                      </div>
                    </div>
                    @elseif($switch == 'm')

                    <div class="row mt-2">
                      <div class="col">
                        <label for="">Uang SPP</label>
                        <input type="number" class="form-control" placeholder="Isi Manual" wire:model='spp'>
                        <div class="text-danger">
                          @error('spp')
                              {{$message}}
                          @enderror
                       </div>
                      </div>
                      <div class="col">
                        <label for="">Makan</label>
                        <input type="text" class="form-control" value='{{$status == 'fd' ? 'Rp.200.000' : 'Rp.375.000'}}' readonly>
                      </div>
                    </div>

                    
                    @endif
                    <div class="text-danger">
                        @error('switch')
                            {{$message}}
                        @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="">Subsidi</label>
                        <input type="number" class="form-control" placeholder="Isi Manual" wire:model='subsidi'>
                        <div class="text-danger">
                          @error('subsidi')
                              {{$message}}
                          @enderror
                       </div>
                  </div>
              </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="bayar()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="history" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">History Pembayaran</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h5>3 Pembayaran Terakhir</h5>
                <table class="table table-sm table-bordered">
                  <tr>
                    <th>Bulan</th>
                    <th>SPP/Makan</th>
                    <th>Subsidi</th>
                    <th>Total</th>
                    <th>Tgl Byr</th>
                  </tr>
                  @isset($data2)
                  @foreach ($data2 as $d)
                  <tr>
                    <td>{{$d->bulan}} {{$d->tahun}}</td>
                    <td>Rp.{{number_format($d->spp + $d->makan)}}</td>
                    <td>Rp.{{number_format($d->subsidi)}}</td>
                    <td>Rp.{{number_format($d->total)}}</td>
                    <td>{{Carbon\Carbon::parse($d->created_at)->translatedFormat('d/m/y')}}</td>
                  </tr>
              @endforeach
                  @endisset
                </table>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="req" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pengajuan Subsidi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
              <div class="row">
               <div class="col">
                 <div class="form-group">
                   <label for="">Nama</label>
                   <input type="text" wire:model="nama" class="form-control" readonly>
                   <div class="text-danger">
                       @error('nis')
                           {{$message}}
                       @enderror
                   </div>
                 </div>
               </div>
               <div class="col">
                 <div class="form-group">
                   <label for="">SPP</label>
                   <input type="text" value="{{$status == 'fd' ? 700000 : 875000}}" class="form-control" readonly>
                 </div>
               </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">Bulan</label>
                    <select wire:model="bulan" class="form-control">
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
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">Tahun</label>
                    <select wire:model="tahun" class="form-control">
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
                </div>
              </div>
                 <div class="form-group">
                   <label for="">Subsidi</label>
                       <input type="number" class="form-control" placeholder="Isi Manual" wire:model='subsidi'>
                       <div class="text-danger">
                         @error('subsidi')
                             {{$message}}
                         @enderror
                      </div>
                 </div>
                 <div class="form-group">
                   <label for="">Kelompok</label>
                       <input type="text" class="form-control" wire:model='kelompok'>
                       <div class="text-danger">
                         @error('kelompok')
                             {{$message}}
                         @enderror
                      </div>
                 </div>
                 <div class="form-group">
                   <label for="">Orang Tua</label>
                       <input type="text" class="form-control" wire:model='ortu'>
                       <div class="text-danger">
                         @error('ortu')
                             {{$message}}
                         @enderror
                      </div>
                 </div>
             </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="prosesreq()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <script>
        window.addEventListener('closeModal', event => {
            $('#add').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#edit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_bayar').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#req').modal('hide');
        })
      </script>

</div>
