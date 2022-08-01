<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <title>ERP | Membership</title> -->
  <title>{{isset($title) ? $title : 'Membership'}}</title>
  <link rel="icon" href="https://seeklogo.com/images/D/dha-lahore-logo-56F7BEF4E7-seeklogo.com.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
  <!-- <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}"> -->
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" />
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}" />
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />

  <style>
    .hr-red { 
      display: block; 
      height: 1px;
      border: 0; 
      border-top: 1px solid red;
      margin: 1em 0; 
      padding: 0; 
    }

    .hr-primary { 
      display: block; 
      height: 1px;
      border: 0; 
      border-top: 1px solid #007bff;
      margin: 1em 0; 
      padding: 0; 
    }

    .br-0 {
      border-radius: 0;
    }

    .form-group.required .col-form-label:after {
      content: "*";
      color: red;
    }

    .lovTable {
      height: 250px;
      overflow-y: auto;
    }

    .input-error {
      outline: 1px solid red;
      /* background-color: yellowgreen; */
    }
  </style>
  @stack('custom-styles')
</head>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-dark navbar-primary">
      <!-- <nav class="main-header navbar navbar-expand-md navbar-dark bg-danger"> -->
      <!-- <div class="container"> -->
      <a href="#" class="navbar-brand">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="DHA Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">DHA CLubs </span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          @include('layouts.includes.common_navbar')
        </ul>
      </div>

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
            <!-- <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span> -->
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <button data-toggle="modal" onclick="openModal()" class="dropdown-item">
              <i class="fas fa-key mr-2"></i> Change Password
            </button>
            <!-- <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout

            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>
      </ul>
      <!-- </div> -->
    </nav>
    <!-- /.navbar -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-7">
              <h1 class="m-0">{{isset($page_title) ? $page_title : (isset($title) ? $title : '')}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-5">
              <div class="float-sm-right">
                @yield('buttons')
              </div>
            </div>
            <!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      @yield('content')
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  @include('layouts.includes.change_password')
  <!-- jQuery -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
  <!-- Toastr JS -->
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
  <!-- DataTables JS -->
  <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
  <!-- Parsley JS -->
  <script src="{{ asset('dist/parsley/parsley.min.js') }}"></script>
  <!-- SWEET ALERT -->
  <script src="{{ asset('dist/sweetalert/sweetalert2.min.js') }}"></script>
  <!-- Bootstrap Switch -->
  <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>


  <!-- custom JS -->
  <script src="{{ asset('dist/js/common/functions.js') }}" defer></script>
  <script src="{{ asset('dist/js/auth/change_password.js') }}" defer></script>

  <script>
    var _baseURL = "{{baseURL()}}";
    var csrf_token = "{{ csrf_token() }}";

    var icon_yes = "{{ asset('dist/img/icon-yes.svg') }}";
    var icon_no = "{{ asset('dist/img/icon-no.svg') }}";
    var profile_pic = "{{ asset('dist/img/profile_pic01.jpg') }}";
    var sign_pic = "{{ asset('dist/img/sign-placeholder.png') }}";
    
    var picsFolderPath = "{{ URL::asset('storage/images/memberpics/') }}";
  </script>

  @stack('custom-scripts')

  @if(Session::has('success'))
  <script>
    Command: toastr["success"]("{!! Session::get('success') !!}")
  </script>
  @endif

  @if(Session::has('sweetAlert'))
  <script>
    const sweetAlert = JSON.parse(<?php echo json_encode(session()->get('sweetAlert')) ?>);
    Swal.fire({
      icon: sweetAlert.type,
      title: sweetAlert.expression,
      text: sweetAlert.message,
    })
  </script>
  @endif

  @if(isset($sessionMsg) && $sessionMsg)
  <script>
    const type = "{{$sessionMsg['type']}}";
    const message = "{!!$sessionMsg['message']!!}";
    Command: toastr[type](message);
  </script>
  @endif

  @if(isset($sessionMsgSA) && $sessionMsgSA)
  <script>
    const expression = "{{$sessionMsgSA['expression']}}";
    const message = "{!!$sessionMsgSA['message']!!}";
    const icon = "{{$sessionMsgSA['type']}}";

    Swal.fire({
      icon: icon,
      title: expression,
      text: message,
    })
  </script>
  @endif

  @if(Session::has('error'))
  <script>
    Command: toastr["error"]("{!! Session::get('error') !!}");
  </script>
  @endif

  @if(Session::has('info'))
  <script>
    Command: toastr["info"]("{!! Session::get('info') !!}")
  </script>

  @endif
  <script>
    $('.select2').select2()
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    function submitForm(event, form_id) {
      event.preventDefault();
      document.getElementById(form_id).submit();
    }
    $('[data-mask]').inputmask();

    function searchMember() {
      const searhStr = $('#search').val();
      console.log(searhStr);
    }

    function openInfoReport(e) {
      e.preventDefault();
      const memberid = prompt('Member ID Please');
      if (!memberid) {
        return; //break out of the function early
      }
      const url = `${_baseURL}members/reports/${memberid}/info`;
      window.location.href = url
      return false;
    }
  </script>

</body>

</html>