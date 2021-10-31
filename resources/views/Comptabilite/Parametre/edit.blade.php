@extends('layout.base')
@section('content')  
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>PARAMETRAGE</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Parametre</li>
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
              <div class="col-md-3"></div>
              <div class="col-md-7"></div>
              <div class="col-md-2">
              </div>
          </div>  
      </div> 
                        <form method="POST" action="{{ route('Parametre_generaux.update', $Parametre->id)}}" enctype="multipart/form-data">
                            <div class="modal-body">
                                {{ method_field('PUT') }}
                               {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                        <label class="control-label">Nom de la Société *</label>
                                        <input class="form-control form-white" value="{{old('Nom') ?: $Parametre->nom_societe}}" type="text" name="Nom" />
                                            {!! $errors->first('Nom', '<span class="error">:message</span>') !!}

                                            <label class="control-label">NIF </label>
                                            <input class="form-control form-white" value="{{old('nif') ?: $Parametre->nif}}" type="text" name="Nif" />
                                            {!! $errors->first('Nif', '<span class="error">:message</span>') !!}

                                  
                                      <label class="control-label">Email *</label>
                                       <input class="form-control form-white" value="{{old('email') ?: $Parametre->email}}" type="email" name="email" />
                                        {!! $errors->first('email', '<span class="error">:message</span>') !!}

                                    <label class="control-label">Télephone *</label>
                                       <input class="form-control form-white" value="{{old('telephone') ?: $Parametre->telephone}}" type="text" name="telephone" />
                                        {!! $errors->first('telephone', '<span class="error">:message</span>') !!}    
                                    
                                
                                     <label class="control-label">Adresse *</label>
                                       <input type="text" class="form-control form-white" name="adresse" value="{{old('adresse') ?: $Parametre->adresse}}">
                                        {!! $errors->first('adresse', '<span class="error">:message</span>') !!}    
                                    
                                    </div>


                                    <div class="col-md-6">
                                        <label class="control-label">Nom Banque 1 </label>
                                        <input class="form-control form-white" value="{{old('first_banque_name') ?: $Parametre->bq_nom_un}}" type="text" name="first_banque_name" />
                                            {!! $errors->first('first_banque_name', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Numero Compte Banquaire 1 </label>
                                            <input class="form-control form-white" value="{{old('first_banque_number') ?: $Parametre->bq_num_un}}" type="text" name="first_banque_number" />
                                            {!! $errors->first('first_banque_number', '<span class="error">:message</span>') !!}

                                  
                                      <label class="control-label">Nom Banque 2 </label>
                                       <input class="form-control form-white" value="{{old('second_banque_name') ?: $Parametre->bq_nom_deux}}" type="text" name="second_banque_name" />
                                        {!! $errors->first('second_banque_name', '<span class="error">:message</span>') !!}

                                    <label class="control-label">Numero Compte Banquaire 2</label>
                                       <input class="form-control form-white" value="{{old('second_banque_number') ?: $Parametre->bq_num_deux}}" type="text" name="second_banque_number" />
                                        {!! $errors->first('second_banque_number', '<span class="error">:message</span>') !!}    
                                    
                                
                                     <label class="control-label">Entete de Vos documents</label>
                                       <input type="file" class="form-control form-white" required="" name="entete" value="{{old('entete') ?: $Parametre->entete}}"/>
                                        {!! $errors->first('entete', '<span class="error">:message</span>') !!}
                                      <img src="{{url($Parametre->entete)}}" class="img-fluid" alt="Inserer L'image d'entete de vos documents">

                                    <label class="control-label">Pied de Page de Vos documents</label>
                                       <input type="file" class="form-control form-white" required="" name="footer" value="{{old('footer') ?: $Parametre->footer}}"/>
                                        {!! $errors->first('footer', '<span class="error">:message</span>') !!}        
                                    <img src="{{url($Parametre->footer)}}" class="img-fluid" alt="Inserer L'image de pied de page de vos documents">
                                    </div>
                                      
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Modifier</button>
                                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Annuler</button>
                            </div>
                           </form>
                              </div>
     </section>     
           @endsection