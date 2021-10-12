@extends('layout.base', ['title' => 'Assurance - Medicament & Service'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
        <h2 style="color: blue;font-weight: bold;text-align: center;">Nouveau Medicament & Service</h2>
        </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Ajout d'un Medicament & Service
                             <a href="{{ route('Medicaments.index') }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-book"></i> Liste des Medicaments & Services
                            </a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form role="form" method="POST" action="{{ route('Medicaments.store')}}">
                                     {{ csrf_field() }}

                                     @include('Medicaments._Form', ['ButtonSubmitTexe'=>'Enregistrer'])
                                     </form>
                                    <br />                    
              </div>

              <div class="col-md-6">
            <form method="POST" action="{{ route('ImporterFile')}}" enctype="multipart/form-data">
                      {{ csrf_field() }}

                    <div class="form-group">
             <label>Fichier Excel  *</label>
           <input type="file" class="form-control" name="services" required="" />
          {!! $errors->first('services', '<span class="error">:message</span>') !!}
        </div>
          <label></label><br>
              <button type="submit" class="btn btn-primary">Importer le Fichier</button>                      
                    </form> 
              </div>
                            </div>
                        </div>
                

@endsection