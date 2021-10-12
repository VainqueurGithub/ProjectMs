@extends('layout.base')
@section('content')  
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Modification d'un Compte</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="container-fluid">
                <div class="container-fluid">
                
                        <div class="card">
                            <div class="card-body">
                        <form method="POST" action="{{ route('ComptePrincipal.update', $ComptePrincipal->id)}}">
                            <div class="modal-body">
                               {{ csrf_field() }}
                              {{ method_field('PUT') }}

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Numero compte *</label>
                                            <input class="form-control form-white" value="{{$ComptePrincipal->NumeroCompte}}" type="text" name="Numero" />
                                            {!! $errors->first('Numero', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Intitulé *</label>
                                            <input class="form-control form-white" value="{{$ComptePrincipal->Intitule}}" type="text" name="Intitule" />
                                            {!! $errors->first('Intitule', '<span class="error">:message</span>') !!}

                                  
                                      <label class="col-md-3">Type Compte</label>
                                    
                                        <select class="form-control form-white" name="TypeCompte">
                                            <option value="{{$Type->id}}">{{ $Type->Class }} {{ $Type->Types }}</option>
                                            @foreach($Types as $Type)
                                                  <option value="{{ $Type->id }}"> {{ $Type->Class }} {{ $Type->Types }}</option>
                                            @endforeach
                                        </select>

                                        {!! $errors->first('TypeCompte', '<span class="error">:message</span>') !!}

                                <div class="form-group row">
                                    <label class="col-md-4">Categorie de Compte</label>
                                    <div class="col-md-8">

                                      @if($ComptePrincipal->Categorie=='Passif') 
                                       <div class="custom-control custom-radio">
                                            <input type="radio" checked="" class="custom-control-input" id="customControlValidation1" name="Categorie" value="Passif">
                                            <label class="custom-control-label" for="customControlValidation1">Passif</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="Actif">
                                            <label class="custom-control-label" for="customControlValidation2">Actif</label>
                                        </div>
                                      @elseif($ComptePrincipal->Categorie=='Actif') 
                                       <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation1" name="Categorie" value="Passif">
                                            <label class="custom-control-label" for="customControlValidation1">Passif</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="Actif" checked="">
                                            <label class="custom-control-label" for="customControlValidation2">Actif</label>
                                        </div>
                                      @else
                                       <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation1" name="Categorie" value="Passif">
                                            <label class="custom-control-label" for="customControlValidation1">Passif</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="Actif">
                                            <label class="custom-control-label" for="customControlValidation2">Actif</label>
                                        </div>
                                      @endif
                                    </div>
                                </div>
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Modifier</button>
                                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Annuler</button>
                            </div>
                           </form>
                               </div>
                               </div>
                               
                        </div>
                        </div>

                    </div>
                   
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
           @endsection