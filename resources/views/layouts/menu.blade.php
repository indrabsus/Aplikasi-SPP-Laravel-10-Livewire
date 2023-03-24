<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    @if (Auth::user()->level == 'admin')
    <li class="nav-item">
        <a href="{{route('indexadmin')}}" class="nav-link {{ Route::currentRouteName() == 'indexadmin' ? 'active':''}}">
          <i class="nav-icon fa fa-home"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('usermgmt')}}" class="nav-link {{ Route::currentRouteName() == 'usermgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-users"></i>
          <p>
            User Manajemen
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('groupmgmt')}}" class="nav-link {{ Route::currentRouteName() == 'groupmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-window-restore"></i>
          <p>
            Kelas Manajemen
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('studentmgmt')}}" class="nav-link {{ Route::currentRouteName() == 'studentmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-address-book"></i>
          <p>
            Siswa Manajemen
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('pembayaran')}}" class="nav-link {{ Route::currentRouteName() == 'pembayaran' ? 'active':''}}">
          <i class="nav-icon fa fa-money"></i>
          <p>
            Pembayaran
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('pengajuan')}}" class="nav-link {{ Route::currentRouteName() == 'pengajuan' ? 'active':''}}">
          <i class="nav-icon fa fa-question-circle"></i>
          <p>
            Pengajuan
          </p>
        </a>
      </li>

    @endif
    @if (Auth::user()->level == 'petugas')
    <li class="nav-item">
        <a href="{{route('indexpetugas')}}" class="nav-link {{ Route::currentRouteName() == 'indexpetugas' ? 'active':''}}">
          <i class="nav-icon fa fa-home"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('petugas-groupmgmt')}}" class="nav-link {{ Route::currentRouteName() == 'petugas-groupmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-window-restore"></i>
          <p>
            Kelas Manajemen
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('petugas-studentmgmt')}}" class="nav-link {{ Route::currentRouteName() == 'petugas-studentmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-address-book"></i>
          <p>
            Siswa Manajemen
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('petugas-pembayaran')}}" class="nav-link {{ Route::currentRouteName() == 'petugas-pembayaran' ? 'active':''}}">
          <i class="nav-icon fa fa-money"></i>
          <p>
            Pembayaran
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('petugas-pengajuan')}}" class="nav-link {{ Route::currentRouteName() == 'petugas-pengajuan' ? 'active':''}}">
          <i class="nav-icon fa fa-question-circle"></i>
          <p>
            Pengajuan
          </p>
        </a>
      </li>
      @endif
      @if (Auth::user()->level == 'owner')
      <li class="nav-item">
        <a href="{{route('indexowner')}}" class="nav-link {{ Route::currentRouteName() == 'indexowner' ? 'active':''}}">
          <i class="nav-icon fa fa-home"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('owner-pembayaran')}}" class="nav-link {{ Route::currentRouteName() == 'owner-pembayaran' ? 'active':''}}">
          <i class="nav-icon fa fa-money"></i>
          <p>
            Pembayaran
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('owner-pengajuan')}}" class="nav-link {{ Route::currentRouteName() == 'owner-pengajuan' ? 'active':''}}">
          <i class="nav-icon fa fa-question-circle"></i>
          <p>
            Pengajuan
          </p>
        </a>
      </li>
      @endif

      @if (Auth::user()->level == 'majelis')
      <li class="nav-item">
        <a href="{{route('indexmajelis')}}" class="nav-link {{ Route::currentRouteName() == 'indexmajelis' ? 'active':''}}">
          <i class="nav-icon fa fa-home"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('majelis-studentmgmt')}}" class="nav-link {{ Route::currentRouteName() == 'majelis-studentmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-address-book"></i>
          <p>
            Siswa Manajemen
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('majelis-pengajuan')}}" class="nav-link {{ Route::currentRouteName() == 'majelis-pengajuan' ? 'active':''}}">
          <i class="nav-icon fa fa-question-circle"></i>
          <p>
            Pengajuan
          </p>
        </a>
      </li>
      @endif


    <li class="nav-item">
      <a href="{{route('logout')}}" class="nav-link">
        <i class="fa fa-sign-out"></i>
        <p>
          Logout
        </p>
      </a>
    </li>
  </ul>
</nav>
