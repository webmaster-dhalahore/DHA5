<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- <nav class="main-header navbar navbar-expand navbar-dark bg-danger"> -->
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('home') }}" class="nav-link">Home</a>
    </li>

    <li class="nav-item dropdown">
      <a id="reportsSubMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reports</a>
      <ul aria-labelledby="reportsSubMenu" class="dropdown-menu border-0 shadow">
        <!-- Level two dropdown-->

        <li class="dropdown-submenu dropdown-hover text-sm">
          <a id="memberReports" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Membership</a>
          <ul aria-labelledby="memberReports" class="dropdown-menu border-0 shadow">

            <li><a href="{{ route('member.reports.member-info') }}" class="dropdown-item">Member Info</a></li>


            <li><a href="{{ route('member.reports.member-profile') }}" class="dropdown-item">Member Profile</a></li>


            <li><a href="{{ route('member.reports.ageWise') }}" class="dropdown-item">Member List Age Wise</a></li>


            <li><a href="{{ route('member.reports.dependents') }}" class="dropdown-item">Member List Dependents</a></li>


            <li><a href="{{ route('member.reports.summary') }}" class="dropdown-item">Member Summary</a></li>

            <li><a href="{{ route('member.reports.member-ledger') }}" class="dropdown-item">Member Ledger</a></li>
          </ul>
        </li>

        <li class="dropdown-submenu dropdown-hover text-sm">
          <a id="accountsReports" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Accounts</a>
          <ul aria-labelledby="accountsReports" class="dropdown-menu border-0 shadow">
            <li><a href="#" class="dropdown-item">Acc Report One</a></li>
            <li><a href="#" class="dropdown-item">Acc Report Two</a></li>
          </ul>
        </li>
        <!-- End Level two -->
      </ul>
    </li>


  </ul>

  <!-- Right navbar links -->
  <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user mr-2"></i> {{auth()->user()->name }}
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <button data-toggle="modal" onclick="openModal()" class="dropdown-item">
          <i class="fas fa-key mr-2"></i> Change Password
        </button>
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->