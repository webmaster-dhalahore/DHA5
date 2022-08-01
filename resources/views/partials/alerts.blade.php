@if(session('success'))
<div class="container">
  <div class="alert alert-success alert-dismissible fade show sessions" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>
@endif

@if(session('warning'))
<div class="container">
  <div class="alert alert-warning alert-dismissible fade show sessions" role="alert">
    {{ session('warning') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>
@endif

@if(session('error'))
<div class="container">
  <div class="alert alert-danger alert-dismissible fade show sessions" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>
@endif