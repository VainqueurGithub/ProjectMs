@extends('layout.base', ['title' => 'Tableau De Bord'])
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Adhésion</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Advanced Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
         <form id="regForm" method="POST" action="{{ route('Affiliers.store')}}">
            {{ csrf_field() }}  
            @include('Affiliers._Form', ['ButtonSubmitTexe'=>'Enregistrer'])
         </form>
    </section>
  </div>
  @endsection