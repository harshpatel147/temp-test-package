@extends('layouts.app')
@section('title', 'Dashboard Page')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @if (session()->has('alertMsg'))
            <div class="alert {{ session()->get('alertClass', 'alert-info') }}" role="alert">
                {{ session()->get('alertMsg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        
        <h1 class="text-black-50">You are logged in!</h1>
      </div>
    </div>
@endsection

@section('stylesheet')
    <!--  -->
@endsection
@section('scripts')
    <!--  -->
@endsection