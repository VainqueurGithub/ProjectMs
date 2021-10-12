@extends('layout.base', ['title' => 'Assurance - Nouveau Service'])
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Origine</h1>
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
 <!-- Main content -->
    <section class="content">
      <!-- Form Elements -->
    <div class="card card-default">
        <div class="card-header">
          <div class="row">
              <div class="col-md-3"> Ajout d'un Service</div>
              <div class="col-md-7"></div>
              <div class="col-md-2">
                   <a href="{{ route('Services.index') }}" style="text-decoration: none;color: white">
                <div class="btn btn-info pull-right"  style="margin-top: -5px">
                 <i class="fa fa-book"></i> Liste des Services
                </a>
              </div>
          </div>  
      </div>    
                                    <form role="form" method="POST" action="{{ route('Services.store')}}">
                                     {{ csrf_field() }}  
                                      @include('Services._Form', ['ButtonSubmitTexe'=>'Enregistrer'])

       
                                        
        
        <button type="reset" class="btn btn-default">Annuler</button>

        </form>
    </div>
     </section> 
@endsection 
