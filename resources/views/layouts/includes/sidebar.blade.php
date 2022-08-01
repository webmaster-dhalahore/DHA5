<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 ">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="DHA Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">DHA {{ auth()->user()->club->name }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <i class="fas fa-user text-light fa-2x"></i>
      </div>
      <div class="info">
        <a href="#" class="d-block">{{auth()->user()->name}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2 text-sm">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="#" class="nav-link">
            <!-- <i class="nav-icon fas fa-tachometer-alt"></i> -->
            <i class="nav-icon fas fa-address-card"></i>
            <p> Membership <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{ route('member.index') }}" class="nav-link">
                <i class="fas fa-list-ol nav-icon"></i>
                <p>Members List</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('member.create') }}" class="nav-link">
                <i class="fas fa-user-plus nav-icon"></i>
                <p>Create Member</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('member.updateStatus') }}" class="nav-link">
                <i class="fas fa-user-lock nav-icon"></i>
                <p>Update Member Status</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('member.categories.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Member Categories</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('member.types.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Member Types</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>