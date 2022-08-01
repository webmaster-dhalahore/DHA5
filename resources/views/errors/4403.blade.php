@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
    <div class="text-center">
          <h1><i class="fas fa-ban text-danger fa-5x mr-3"></i></h1>
          <h2 class="mb-0"><i class="fas fa-exclamation-triangle mr-2"></i>Forbidden</h2>
          <h5 class="mt-0">Unauthorized Access!</h5>
          <!-- <h4><i class="fas fa-ban mr-3"></i>{{ __('403 Forbidden') }}</h4> -->
          <!-- <p><i class="fas fa-user-slash text-danger mr-3"></i>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE!</p> -->
          <!-- <p><i class="fas fa-user-slash text-danger fa-2x mr-3"></i>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE!</p> -->
        </div>
    </div>
  </div>
</div>
@endsection