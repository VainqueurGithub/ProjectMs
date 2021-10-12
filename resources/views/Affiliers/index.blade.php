@extends('layout.base', ['title' => 'Tableau De Bord'])
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-body">
                              <form method="POST" action="{{route('researchAffilier')}}">
                              <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-group row">
                                      <div class="col-sm-11">
                                        <input type="text" class="form-control" id="inputEmail3" name="Code" placeholder="Code Adhérant">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-md-3">
                                    <div class="form-group row">
                                      <div class="col-sm-11">
                                        <input type="text" value="" class="form-control" name='nom' placeholder="Nom Adhérant">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-md-3">
                                    <div class="form-group row">
                                      <div class="col-sm-11">
                                        <input type="text" value="" class="form-control" name='prenom' placeholder="Prénom Adhérant">
                                      </div>
                                    </div>
                                  </div>
                                  
                                 <div class="col-md-3">
                                    <div class="form-group row">
                                      <!-- <label for="inputEmail3" class="col-sm-3 col-form-label">Date de naissance</label> -->
                                      <div class="col-sm-11">
                                        <input type="text" value="" class="form-control" name='piece' placeholder="Pièce Identité">
                                      </div>
                                    </div>
                                  </div>     
                              </div>

                              <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-group row">
                                      <div class="col-sm-11">
                                        <select class="form-control select2" name="Origine">
                                            <option></option>
                                            @foreach($Origines as $Origine)
                                              <option value="{{$Origine->id}}">{{$Origine->Origine}}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-md-3">
                                    <div class="form-group row">
                                      <div class="col-sm-11">
                                        <input type="date" name="dateEntree" class="form-control">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-md-3">
                                    <div class="form-group row">
                                      <div class="col-sm-11">
                                        <input type="number" min="0" name="AnneNaiss" class="form-control" id="inputEmail3" placeholder="Année de naissance">
                                      </div>
                                    </div>
                                  </div>
                                      
                                  <div class="col-md-3">
                                    <div class="form-group row">
                                      <div class="col-sm-11">
                                        <select class="form-control select2" name="Statut">
                                            <option value="0">Entrée</option>
                                            <option value="1">Sortie</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                      
                                 <div class="col-md-3">
                                    <div class="form-group row">
                                      <!-- <label for="inputEmail3" class="col-sm-3 col-form-label">Date de naissance</label> -->
                                      <div class="col-sm-11">
                                          <button type="submit" class="form-control btn btn-info" name='operation' value='RechercherPatient'><i class="fas fa-search"></i> Rechercher Adhérant</button>  
                                       
                                      </div>
                                    </div>
                                  </div> 
                              </div>
                        </form>              
                          </div>
                      <!-- /.card-body -->
                    </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </div>  
 </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Affiliers</h3>
                <div class="row">
                  <div class="col-md-10"></div>
                  <div class="col-md-2">
                     @if(session()->get('Profil') == 'User')
                     <a href="{{ route('Affiliers.create') }}">
                        <button type="button" class="btn btn-primary btn-sm">
                          <i class="nav-icon fas fa-plus"></i> Ajouter un Affilier
                        </button>
                     </a>
                    @endif
                       
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>Code</th>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Origine</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($Affiliers as $Affilie)
                                  
                                      <tr class='odd gradeX'>
                                        <td><input type="checkbox" name='delet.".$Affilie->id."' value="{{$Affilie->id}}"></td>
                                        <td>{{$Affilie->Code}}</td>
                                        <td>{{$Affilie->Nom}}</td>
                                        <td>{{$Affilie->Prenom}}</td>
                                        <td>{{$Affilie->Origine}}</td>
                                      <td>
                   
                @if(session()->get('Profil') == 'Partenaire')
                <button style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopup(this); return false;" value="{{$Affilie->id}}"><i class="fa fa-eye"></i></button>
                
                @if($Affilie->status==0)
                <button style="border: none;" value="{{$Affilie->id}}" onclick="openPrestationModal(this)" data-toggle="modal" data-target="#modal-default">
                    <i class='fa fa-plus'></i>
                </button>
                @else
                  <a href="#" class="badge badge-danger">sortie</a>
                @endif
                @elseif(session()->get('Profil') != 'Partenaire')
                   <a href="{{route('Affiliers.edit', $Affilie->id)}}"><i class='fa fa-edit'></i></a>

                    <form action="{{route('Affiliers.destroy', $Affilie->id)}}" method='POST' style='display: inline-block;' onsubmit='return confirm("Etez -vous sur de cette Operation ?")'>
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    
                    <button style="border: none;" onclick='return confirm("Etez -vous sur de cette Operation ?")'>
                    <i class='fa fa-trash'></i>
                    </button>
                    </form>
                   
                    <button style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopup(this); return false;" value="{{$Affilie->id}}"><i class="fa fa-eye"></i></button>

                  @if($Affilie->Partenaire!="" OR $Affilie->Partenaire!=null)
                    @if($Affilie->status==0)
                      <button style="border: none;" value="{{$Affilie->id}}" onclick="openPartenaireModal(this)" data-toggle="modal" data-target="#modal-paterner">
                       <i class='fa fa-plus'></i>
                       </button>
                    @else
                      <a href="#" class="badge badge-danger">sortie</a>
                    @endif
                  @endif  
                     <button style="border: none;" value="{{$Affilie->id}}" onclick="thisAffilier(this)" data-toggle="modal" data-target="#registre_mvt_affilier">
                            <i class='fa fa-plus'></i>
                      </button>
                @endif
                
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





<!-- MODAL POUR AFFICHER LES PRESTATION QUE PEUT AVOIR UN ADHERANT DEBUT-->
  <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">CHOISIR L'OPTION</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                  <div class="card-body">
                    <div class="row">
                     <div id="Produit4">
                       

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
<!-- MODAL POUR AFFICHER LES PRESTATION QUE PEUT AVOIR UN ADHERANT FIN-->


<!-- MODAL POUR AFFICHER LES PRESTATION QUE PEUT AVOIR UN ADHERANT DEBUT-->
  <div class="modal fade" id="modal-default1">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">CHOISIR L'OPTION</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                  <div class="card-body">
                    <div class="row">
                     <div id="ServiceId">
                       

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
<!-- MODAL POUR AFFICHER LES PRESTATION QUE PEUT AVOIR UN ADHERANT FIN-->


<!-- MODAL POUR AFFICHER LES PATENAIRE D'UN ADHERANT DEBUT-->
  <div class="modal fade" id="modal-paterner">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">CHOISIR L'OPTION </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                  <div class="card-body">
                    <div class="row">
                     <div id="Paterner">
                       

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
<!-- MODAL POUR AFFICHER LES LES PATENAIRE D'UN ADHERANT FIN-->

<!-- MODAL POUR LES MOUVEMENT DE L'AFFILIER DEBUT-->
  <div class="modal fade" id="registre_mvt_affilier">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">MOUVEMENT DE L'AFFILIER </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form action="{{route('mouvement_affilier.store')}}" method="POST">  
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                      <div class="form-group" style="display: none;">
                       <input type="text" class="form-control" name="beneficiaire" id="idAff">
                       <input type="text" class="form-control" name="beneficiaire_type" value="1">
                      </div> 
                     <div class="form-group">
                       <select class="form-control" name="mvt_affilier" id="statu">
                        
                       </select>
                     </div>  
                     <div class="form-group">
                       <input type="date" name="datemvt" class="form-control">
                     </div>
                     <div class="form-group">
                       <textarea name="motif" class="form-control"></textarea>
                     </div>

                     <button type="submit" class="btn btn-primary">Enregistrer</button>
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
<!-- MODAL POUR LES MOUVEMENT DE L'AFFILIER FIN-->

@endsection 
<script type="text/javascript">
  function thisAffilier(va){
    var aff = $(va).val();
    var type_ben = 1;
    $('#idAff').val(aff);
     var route = "{{ route('beneficiairestatus', ['aff'=>":aff", 'type_ben'=>":type_ben"])}}";
     route = route.replace(':aff', aff);
     route = route.replace(':type_ben', type_ben);
     $.get(route,
          function(data){
            $('#statu').html(data);
    });
  }
  var WindowObjectReference = null; // variable globale
function openFFPromotionPopup(va) {
     var id = $(va).val();
     var url = "{{ route('Affiliers.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "toolbar=no,scrollbars=no,location=no,statusbar=no,width=940,height=500,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}

function openPrestationModal(va){
     var Affilie = $(va).val();
     var route = "{{ route('addBillForm', ":Affilie") }}";
     route = route.replace(':Affilie', Affilie);
     $.get(route,
          function(data){
            $('#Produit4').html(data);
    });
}

function openPrestationModal1(va){
    var partener = $(va).val();
    var adherant = $('#affilieID').val();
    var url1 = "{{ route('availablePrestation')}}";
     $.get(url1,
      {partener:partener, adherant:adherant},
          function(data){
            $('#ServiceId').html(data);
    });
}

function openPartenaireModal(va){
     var Affilie = $(va).val();
     var route = "{{ route('availablePartener', ":Affilie") }}";
     route = route.replace(':Affilie', Affilie);
     $.get(route,
          function(data){
            $('#Paterner').html(data);
    });
}

function openFFPromotionPopupPrestation(va){
     var service = $(va).val();
     var adherant = $('#adherantId').val();
      document.getElementById('modal-paterner').style.display='none';
     var url1 = "{{ route('form_prest', ['service'=>":service", 'adherant'=>":adherant"])}}";
     url1 = url1.replace(':service', service);
     url1 = url1.replace(':adherant', adherant);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url1,
           "PromoteFirefoxWindowName", "width=830,height=550,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}
</script>