@extends('layout.base')
@section('content')                        
                         <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
           
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                  <div class="row">
                                      <div class="col-4"><a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                            <i class="ti-plus"></i> Nouveau Compte Repport
                                    </a></div>
                                  </div>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Numero</th>
                                                <th>Type Compte</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Comptes as $Compte)
                                                <tr>
                                                    <td>{{$Compte->id}}</td>
                                                    <td><button style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopup(this); return false;" value="{{$Compte->id}}">{{$Compte->NumeroCompte}}</button></td>
                                                    <td>{{$Compte->Type_compte}}</td>
                                                    <td><button class="btn btn-danger" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopupSettedAccount(this); return false;" value="{{$Compte->id}}"><i class="fas fa-eye"></i> comptes</button></td>
                                                </tr>   
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

               <!-- Modal Add Category -->
                <div class="modal fade none-border" id="add-new-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Creer un Compte</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        <form method="POST" accept="{{ route('CompteRepport.store')}}">
                            <div class="modal-body">
                               
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Numero compte *</label>
                                            <input class="form-control form-white" placeholder="Numero compte" type="text" name="Numero" />
                                            {!! $errors->first('Numero', '<span class="error">:message</span>') !!}

                                           
                                    <div class="form-group row">
                                    <label class="col-md-4">Type de compte</label>
                                    <div class="col-md-8">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation1" name="TypeCompte" value="Debiteur">
                                            <label class="custom-control-label" for="customControlValidation1">Débiteur</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="TypeCompte" value="Crediteur">
                                            <label class="custom-control-label" for="customControlValidation2">Créditeur</label>
                                        </div>
                                        {!! $errors->first('TypeCompte', '<span class="error">:message</span>') !!}
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


                  <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">CHOISIR LES COMPTES CONSERNES</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{route('attachedAccount')}}" enctype="multipart/form-data" onsubmit='return confirm("Etez - vous sur de cette Operation ?")'>
                {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                        <input type="hidden" required="required" name="CompteR" id="CompteR">
                           <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Journal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($ComptePrincipal as $CompteP) 
                                               <tr>
                                                 <td><input type="checkbox" name="compte[]" value="{{ $CompteP->id}}"></td>
                                                 <td>{{ $CompteP->NumeroCompte}}</td>
                                                 <td>{{ $CompteP->Intitule }}</td>
                                                 <td><button></button></td>
                                               </tr>
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>

                      <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success swalDefaultSuccess" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-save"></i> Valider L'action</button>
                        </div>
                      </div>

                    </div>
                  </div>

              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
  var WindowObjectReference = null; // variable globale
 
function openFFPromotionPopup(va) {
     var id = $(va).val();
     var url = "{{ route('CompteRepport.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "width=420,height=230,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}

function openFFPromotionPopupSettedAccount(va) {
     var id = $(va).val();
     var url = "{{ route('SettedAccountAsRepported', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "width=420,height=230,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}

</script>
