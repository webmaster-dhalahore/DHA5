<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <title>ERP | Membership</title> -->
  <title>{{isset($title) ? $title : 'PDF'}}</title>
  <link rel="icon" href="https://seeklogo.com/images/D/dha-lahore-logo-56F7BEF4E7-seeklogo.com.png">

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" /> -->
  <!-- Font Awesome Icons -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic"> -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
  <!-- Milligram CSS -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css"> -->
  @stack('custom-styles')
</head>

<body>
  <div class="container">
    @yield('content')
  </div>
</body>

</html>