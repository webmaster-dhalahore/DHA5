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

    .uppercase {
      text-transform: uppercase;
    }
  </style>
  @stack('custom-styles')
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <div class="wrapper">



    @include('layouts.includes.navbar')
    @include('layouts.includes.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">@if(isset($icon)) {!! $icon !!} @endif {{ isset($page_title) ? $page_title : (isset($title) ? $title : '' )}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
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

  @if(Session::has('sweetAlert2'))
  <script>
    const sweetAlert2 = JSON.parse(<?php echo json_encode(session()->get('sweetAlert2')) ?>);
    Swal.fire({
      icon: sweetAlert2.type,
      title: sweetAlert2.expression,
      text: sweetAlert2.message,
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
    $(document).on("change", ".date-input", function() {
      console.log('hey.....');
      console.log(this.value, this.getAttribute('data-date-format'));
      this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format(this.getAttribute("data-date-format"))
      )
    }).trigger("change")

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