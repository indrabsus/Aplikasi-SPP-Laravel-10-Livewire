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
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Bulan</th>
            <th>Biaya</th>
            <th>Subsidi</th>
            <th>Kelompok</th>
            <th>Orang Tua</th>
            <th>ACC</th>
            <th>Tgl Pengajuan</th>
            @if (Auth::user()->level == 'admin' || Auth::user()->level == 'petugas')
            <th>Aksi</th>
            @endif
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->nis }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->nama_kelas }}</td>
                <td>{{ $d->bulan }} {{$d->tahun}}</td>
                <td>Rp. {{ number_format($d->makan + $d->spp) }}</td>
                <td>Rp. {{ number_format($d->subsidi) }}</td>
                <td>{{ $d->kelompok }}</td>
                <td>{{ $d->org_tua }}</td>
                <td>@if ($d->acc == 'y')
                    <i class="fa fa-check"></i>
                    @else
                    <i class="fa fa-times"></i>
                @endif</td>
                <td>{{date('d/m/y', strtotime($d->tgl_pengajuan))}}</td>
                @if (Auth::user()->level == 'admin' || Auth::user()->level == 'petugas')
                <td><a class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#k_acc" wire:click="k_acc({{ $d->id_bayar }})"><i class="fa fa-check"></i></a>
                  <a class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->id_bayar }})"><i class="fa fa-trash"></i></a>
              </td>  
                @endif
                
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
                <label for="">Nama Kelas</label>
                <input type="text" wire:model="nama_kelas" class="form-control">
                <div class="text-danger">
                    @error('nama_kelas')
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
                <label for="">Nama Kelas</label>
                <input type="text" wire:model="nama_kelas" class="form-control">
                <div class="text-danger">
                    @error('nama_kelas')
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


      <div class="modal fade" id="k_acc" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Acc Pengajuan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                      <label for="">NIS</label>
                      <input type="text" wire:model="nis" class="form-control" readonly>
                      <div class="text-danger">
                          @error('nis')
                              {{$message}}
                          @enderror
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
                        <input type="number" wire:model="subsidi" class="form-control">
                        <div class="text-danger">
                            @error('subsidi')
                                {{$message}}
                            @enderror
                        </div>
                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="prosesacc()">Save changes</button>
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
            $('#k_acc').modal('hide');
        })
      </script>

</div>
