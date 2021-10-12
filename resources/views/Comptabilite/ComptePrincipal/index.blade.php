@extends('layout.base')
@section('content')                        
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Classes comptable</h3>
                <div class="row">
                  <div class="col-md-8"></div>
                  <div class="col-4">
                   <a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                        <i class="ti-plus"></i> Nouveau Compte
                    </a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                                            <tr>
                                                <th>Numero</th>
                                                <th>Intitulé</th>
                                                <th>Classe</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($Comptes as $Compte)
                                             <tr>
                                                <td>{{$Compte->NumeroCompte}}</td>
                                                <td>{{$Compte->Intitule}}</td>
                                                <td>{{$Compte->type->Types}}</td>
                                                <td>
                                                    <button data-toggle="modal" data-target="#add-older-event" value="{{$Compte->id}}" onclick="getComptePrincipal(this)">
                                                     <i class="fas fa-edit"></i>
                                                  </button>
                                                    <form action="{{route('ComptePrincipal.destroy', $Compte->id)}}" method='POST' style='display: inline-block;' onsubmit="return confirm('Etez-vous sur de cette Operation ?')">
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                <button onclick="return confirm('Etez -vous sur de cette Operation ?')"><i class='fas fa-trash'></i>
               </button>
               </form>
              </td>
             </tr>
                                           @endforeach
                                         </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </section>
      </div>

                     <!-- Modal Add Category -->
                <div class="modal fade none-border" id="add-new-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Creer un Compte</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        <form method="POST" action="{{ route('ComptePrincipal.store')}}">
                            <div class="modal-body">
                               
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Numero compte *</label>
                                            <input class="form-control form-white" placeholder="Numero compte" type="text" name="Numero" />
                                            {!! $errors->first('Numero', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Intitulé *</label>
                                            <input class="form-control form-white" placeholder="Intitulé" type="text" name="Intitule" />
                                            {!! $errors->first('Intitule', '<span class="error">:message</span>') !!}

                                  
                                      <label class="col-md-3">T.Compte*</label>
                                    
                                        <select class="form-control select2" name="TypeCompte">
                                            @foreach($Types as $Type)
                                                  <option value="{{ $Type->id }}"> {{ $Type->Class }} {{ $Type->Types }}</option>
                                            @endforeach
                                        </select>

                                        {!! $errors->first('TypeCompte', '<span class="error">:message</span>') !!}

                                     <label class="col-md-3">Appartenance </label>
                                    
                                        <select class="form-control form-white" name="Appartenance">
                                            <option></option>
                                            <option value="exploitation">exploitation</option>
                                            <option value="financier">financièr(e)</option>
                                            <option value="exceptionnel">exceptionnel(le)</option>
                                        </select>

                                        {!! $errors->first('Appartenance', '<span class="error">:message</span>') !!}    

                                  <div class="form-group row">
                                    <label class="col-md-4">Categorie de Compte</label>
                                    <div class="col-md-8">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation1" name="Categorie" value="Passif">
                                            <label class="custom-control-label" for="customControlValidation1">Passif</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="Actif">
                                            <label class="custom-control-label" for="customControlValidation2">Actif</label>
                                        </div>
                                    </div>
                                 </div>

                                  <div class="form-group row">
                                    <label class="col-md-4">Compte de Resultat</label>
                                    <div class="col-md-2">
                                        <div class="custom-control">
                                            <input type="checkbox" name="ResultatAccount" value="1">
                                        </div>
                                    </div>
                                 </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Enregistrer</button>
                                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Annuler</button>
                            </div>
                           </form> 
                        </div>
                    </div>
                </div>





                                <div class="modal fade none-border" id="add-older-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Modifier un Compte</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        <form method="POST" action="{{ route('UpdateComptePrincipal')}}">
                            <div class="modal-body">
                               
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="row">
                                        <input type="text" name="Identifiant" id="Identifiant" style="display: none;">
                                        <div class="col-md-12">
                                            <label class="control-label">Numero compte *</label>
                                            <input class="form-control form-white" placeholder="Numero compte" type="text" name="Numero" id="Numero" />
                                            {!! $errors->first('Numero', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Intitulé *</label>
                                            <input class="form-control form-white" placeholder="Intitulé" type="text" name="Intitule" id="Intitule" />
                                            {!! $errors->first('Intitule', '<span class="error">:message</span>') !!}

                                  
                                      <label class="col-md-3">T.Compte*</label>
                                    
                                        <select class="form-control select2" name="TypeCompte" id="Type">
                                            
                                        </select>

                                        {!! $errors->first('TypeCompte', '<span class="error">:message</span>') !!}

                                     <label class="col-md-3">Appartenance </label>
                                    
                                        <select class="form-control form-white" name="Appartenance" id="Appartenance">
                                           
                                        </select>

                                        {!! $errors->first('Appartenance', '<span class="error">:message</span>') !!}    

                                    <div class="form-group row">
                                    <label class="col-md-8">Categorie de Compte</label>
                                    <div class="col-md-4" id="Categorie">
                                       
                                    </div>
                                </div>

                                   <div class="form-group row">
                                    <label class="col-md-4">Compte de Resultat</label>
                                    <div class="col-md-2">
                                        <div class="custom-control" id="Resultat">
                                            
                                        </div>
                                    </div>
                                 </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Enregistrer</button>
                                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Annuler</button>
                            </div>
                           </form> 
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
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
            <!-- ============================================================== -->
            <!-- ============================================================== -->

                        @endsection

<script type="text/javascript">
  function getComptePrincipal(va){
    var compte= $(va).val();
    $.get('{{route('getComptePrincipalId')}}',
    {compte:compte},
    function(data){
      var donnee = data.split("#");
      $("#Identifiant").val(compte);
      $("#Numero").val(donnee[1]);
      $("#Intitule").val(donnee[2]);
      $('#Type').html(donnee[3]);
      $('#Appartenance').html(donnee[4])
      $('#Categorie').html(donnee[5])
      $('#Resultat').html(donnee[6])
    });
  }
</script>                                  