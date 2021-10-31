@extends('layout.base', ['title' => 'Assurance - Medicament & Service'])
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Prestation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Service</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
        <section class="content">
      <!-- Form Elements -->
    <div class="card card-default">
        <div class="card-header">
          <div class="row">
              <div class="col-md-4"> Modification d'une Prestation</div>
              <div class="col-md-5"></div>
              <div class="col-md-3">
                   <a href="{{ route('Medicaments.index') }}" style="text-decoration: none;color: white">
                <div class="btn btn-info pull-right"  style="margin-top: -5px">
                 <i class="fa fa-book"></i> Liste des Prestation
                 </div>
                </a>
              </div>
          </div>  
      </div> 

      <div class="row" style="padding: 10px;">
        <div class="col-md-3"></div>
        <div class="col-md-6">
                                    <form role="form" method="POST" action="{{ route('medicamentPartenaire.update', $medicament->id)}}">
                                     {{ csrf_field() }}
                                     {{ method_field('PUT') }}
                                     @include('medicamentPartenaire._Form', ['ButtonSubmitTexe'=>'Modifier'])
                                   

        </form>
          </div>
     </div>
  </div>
@endsection