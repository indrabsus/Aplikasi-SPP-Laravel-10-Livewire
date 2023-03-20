<div>
<h3>Dashboard</h3>
<hr>
<div class="row">
  
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$fd}}</h3>

                <p>Siswa Fullday</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
               </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$bs}}</h3>

                <p>Siswa Boarding</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>Rp. {{number_format($subsidi)}}</h3>

                <p>Total Subsidi</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
               </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Rp. {{number_format($total)}}</h3>

                <p>Total Pendapatan</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              </div>
          </div>
          <!-- ./col -->
        </div>
</div>
