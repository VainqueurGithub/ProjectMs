@extends('layout.base')
@section('content')                        

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sous Comptes</h3>
                <div class="row">
                  <div class="col-md-8"></div>
                 <div class="col-4" onclick="showform()"><a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                            <i class="ti-plus"></i> Nouveau Sous Compte.
                                    </a></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                                            <tr>
                                                <th>Numero</th>
                                                <th>Intitulé</th>
                                                <th>Compte Subdivisionnaire</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($SComptes as $SCompte)
                                             <tr>
                                                <td>{{$SCompte->NumeroCompte}}</td>
                                                <td>{{$SCompte->Intitule}}</td>
                                                <td>{{$SCompte->compte_subdivionnaire->NumeroCompte}}</td>
                <td>
              <button data-toggle="modal" data-target="#add-older-event" value="{{$SCompte->id}}" onclick="getSCompte(this)">
                      <i class="fas fa-edit"></i>
                  </button>
              <form action="{{route('sous_compte.destroy', $SCompte->id)}}" method='POST' style='display: inline-block;' onsubmit="return confirm('Etez-vous sur de cette Operation ?')">
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
                                <h4 class="modal-title"><strong>Creer un Sous Compte</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        <form method="POST" action="{{ route('sous_compte.store')}}">
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

                                            <label class="control-label">Compte Subdivisionnaire *</label>
                                             <select class="form-control select2" name="Compte">
                                                <option></option>
                                                @foreach($Comptes as $Compte)
                                                 <option value="{{ $Compte->id }}"> {{ $Compte->NumeroCompte}} - {{ $Compte->Intitule}}</option>
                                                @endforeach 
                                             </select>
                                            {!! $errors->first('Compte', '<span class="error">:message</span>') !!}
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
                                <h4 class="modal-title"><strong>Modifier un Sous Compte</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        <form method="POST" action="{{ route('UpdateSousCompte')}}">
                            <div class="modal-body">
                               
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="row">
                                        <div class="col-md-12">
                                          <input type="text" name="Identifiant" id="Identifiant" style="display: none;">
                                            <label class="control-label">Numero compte *</label>
                                            <input class="form-control form-white" placeholder="Numero compte" type="text" name="Numero" id="Numero" />
                                            {!! $errors->first('Numero', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Intitulé *</label>
                                            <input class="form-control form-white" placeholder="Intitulé" type="text" name="Intitule" id="Intitule" />
                                            {!! $errors->first('Intitule', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Compte Subdivisionnaire *</label>
                                             <select class="form-control select2" name="Compte" id="Compte">
                                               
                                             </select>
                                            {!! $errors->first('Compte', '<span class="error">:message</span>') !!}
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
    function showform()
    {
        document.getElementById("add-new-event").style.display = 'flex';
        //document.getElementById("ChangerPassWord").style.display = 'flex';
    }

  function getSCompte(va){
    var compte= $(va).val();
    $.get('{{route('getSCompteId')}}',
    {compte:compte},
    function(data){
      var donnee = data.split("#");
      $("#Identifiant").val(compte);
      $("#Numero").val(donnee[1]);
      $("#Intitule").val(donnee[2]);
      $('#Compte').html(donnee[3]);
    });
  }                   
</script>                        