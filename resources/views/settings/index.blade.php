@extends('layouts.admin', ['title'=> 'Settings', 'page_title' => 'Settings', 'icon' => '<i class="fas fa-cog text-primary mr-1"></i>'])


@section('buttons')
@include('members.includes.homeButton')
@stop


@section('content')
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    Settings Page

  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@stop
