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
              <div class="col-md-3"> Ajout d'une Prestation</div>
              <div class="col-md-6"></div>
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
        <div class="col-md-6">
                                    <form role="form" method="POST" action="{{ route('StoreChange', $medicament->id)}}">
                                     {{ csrf_field() }}
                                     {{ method_field('PUT') }}

        
        <div class="form-group">
         <label>Prix *</label>
           <input type="text" class="form-control" name="Prix" placeholder="Indiquez le Prix Medicament ou Service" value="{{ old('Prix')?: $medicament->prix }}" />
          {!! $errors->first('Prix', '<span class="error">:message</span>') !!}
        </div>

       
          <label></label><br>
              <button type="submit" class="btn btn-primary">Changer le Prix</button>
               <button type="reset" class="btn btn-default">Annuler</button>

        </form>
        </div>   
     
                 
            
                      </div>
     </section> 
@endsection