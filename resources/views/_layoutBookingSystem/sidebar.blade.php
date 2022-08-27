<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ \Request::route()->getName() }}" class="brand-link">
      <img src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">InventorySYSTEMM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ \Request::route()->getName() }}" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        @if (auth()->user()->role_id == 1)
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item {{Request::is('admin/*') ? 'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left "></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('registration_tokens') }}" class="nav-link {{ Route::currentRouteNamed('registration_tokens') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Registration Token</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="ItemCodes" class="nav-link {{ Route::currentRouteNamed('ItemCodes') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Item Codes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="ItemGenres" class="nav-link {{ Route::currentRouteNamed('ItemGenres') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Item Genres</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="items" class="nav-link {{ Route::currentRouteNamed('items') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Items</p>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="beauticians" class="nav-link {{ Route::currentRouteNamed('beauticians') ? 'active' : '' }} ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Beauticians</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Services" class="nav-link {{ Route::currentRouteNamed('Services') ? 'active' : '' }} ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Services</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Products" class="nav-link {{ Route::currentRouteNamed('Products') ? 'active' : '' }} ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Products</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Appointments" class="nav-link {{ Route::currentRouteNamed('Appointments') ? 'active' : '' }} ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Appointments</p>
                  </a>
                </li> --}}
              </ul>
            </li>
          </ul>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item {{Request::is('admin/*') ? 'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Sales
                  <i class="right fas fa-angle-left "></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="PurchaseTransactions" class="nav-link {{ Route::currentRouteNamed('PurchaseTransactions') ? 'active' : '' }} ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Purchases (In)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="SaleTransactions" class="nav-link {{ Route::currentRouteNamed('SaleTransactions') ? 'active' : '' }} ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sales (Out)</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item {{Request::is('admin/*') ? 'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Users
                  <i class="right fas fa-angle-left "></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                {{-- <li class="nav-item">
                  <a href="UserRoles" class="nav-link {{ Route::currentRouteNamed('UserRoles') ? 'active' : '' }} ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User Roles</p>
                  </a>
                </li> --}}
                <li class="nav-item">
                  <a href="Users" class="nav-link {{ Route::currentRouteNamed('Users') ? 'active' : '' }} ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        @else

        @endif
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>