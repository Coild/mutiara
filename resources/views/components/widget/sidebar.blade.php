<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{'#'}}" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ 'Mutiara Store' }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
              <img src="{{ asset('dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
              <a href="#" class="d-block">{{ Auth::user()->nama }} ({{ Auth::user()->level }})</a>
          </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item has-treeview">
                  <a href="{{route('home')}}" class="nav-link">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>Dashboard</p>
                  </a>
              </li>
              <li class="nav-item has-treeview">
                  <a href="{{ route('produk') }}" class="nav-link ">
                      <i class="nav-icon fas fa-th-large"></i>
                      <p>Products</p>
                  </a>
              </li>
              <li class="nav-item has-treeview">
                  <a href="{{ route('jual') }}" class="nav-link ">
                      <i class="nav-icon fas fa-cart-plus"></i>
                      <p>Open POS</p>
                  </a>
              </li>
              <li class="nav-item has-treeview">
                  <a href="{{ route('riwayat') }}" class="nav-link ">
                      <i class="nav-icon fas fa-cart-plus"></i>
                      <p>Riwayat</p>
                  </a>
              </li>
              {{-- <li class="nav-item has-treeview">
                  <a href="{{ '' }}" class="nav-link ">
                      <i class="nav-icon fas fa-users"></i>
                      <p>Customers</p>
                  </a>
              </li> --}}
              <li class="nav-item has-treeview">
                <a href="{{ route('agregat') }}" class="nav-link ">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Laporan Keuangan</p>
                </a>
            </li>
              <li class="nav-item has-treeview">
                  <a href="{{ route('ganti') }}" class="nav-link ">
                      <i class="nav-icon fas fa-cogs"></i>
                      <p>Ganti Password</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
                      <i class="nav-icon fas fa-sign-out-alt"></i>
                      <p>Logout</p>
                      <form action="{{route('logout')}}" method="get" id="logout-form">
                          @csrf
                      </form>
                  </a>
              </li>
          </ul>
      </nav>
      <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>