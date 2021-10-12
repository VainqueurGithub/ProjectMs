@extends('layout.base', ['title' => 'Assurance - Affichage Affilier'])
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-8">
                <h5 style="text-align:justify;">CARTE D'ADHERANT A L'ASSURANCE / Code: {{$Affilier->Code}}</h5>     
          </div>
          
           <div class="col-sm-2">
               <button class="btn btn-info btn-sm" style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopupFicheAdhesion(this); return false;" value="{{$Affilier->id}}" style="text-align:right"><i class="fas fa-users"> Fiche Adhésion</i></button>

          </div>
           <div class="col-sm-2">
               <button class="btn btn-info btn-sm" style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopupCarteAdhesion(this); return false;" value="{{$Affilier->id}}" style="text-align:right"> <i class="fas fa-user"> Carte Adhesion</i></button>
          </div>

          <!--div class="col-sm-2">
               <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-default" style="text-align:right"><i class="fas fa">Importer</i></button>
          </div-->
        </div><hr>
      <div class=" row">
        <div class="col-md-6">
       <div class="row">
                <div class="col-md-2"></div>
                    <div class="col-md-10"><h5 style="font-weight: bold;">IDENTITE COMPLETE</h5></div><hr>  
               </div>
               
               <div class="row">
                <div class="col-md-4">
                   <ul>
                       <li>Nom</li>
                       <li>Prénom</li>
                       <li>Date Entree</li>
                       <li>Origine</li>
                       <li>N° Piece</li>
                       <li>Telephone</li>
                       <li>Né(e), Le</li>
                       <li>Adresse</li>
                   </ul> 
                </div>

                <div class="col-md-8">
                   <ul style="list-style-type: none;">
                       <li>: {{$Affilier->Nom}}</li>
                       <li>: {{$Affilier->Prenom}}</li>
                       <li>: {{$Affilier->DateEntree}}</li>
                       <li>: {{$Origine->Origine}}</li>
                       <li>: {{$Affilier->PieceIndentite}}</li>
                       <li>: {{$Affilier->Telephone}}</li>
                       <li>: {{$Affilier->DateNaiss}}</li>
                       <li>: {{$Affilier->Adresse}}</li>
                   </ul> 
                </div>
               </div>
            </div>
            
            <div class="col-md-6">
                <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-10"><h5 style="font-weight: bold;">AYANTS DROIT 

                  <a data-toggle="modal" data-target="#ajout_beneficiaire_modal" style="text-decoration: none;color: white">
                    <div class="btn btn-info btn-sm" style="margin-top:-5px">
                    <i class="fa fa-plus"></i> Ajouter
                    </a>
                </h5>
                    <ol>
                        @foreach($AyantDroits as $AyantDroit)
                          @if($AyantDroit->Lien=='Lui meme')
                            <li>{{$AyantDroit->Nom}} {{$AyantDroit->Prenom}}  ({{$AyantDroit->Lien}})</li>
                          @else
                            <li>{{$AyantDroit->Nom}} {{$AyantDroit->Prenom}}  ({{$AyantDroit->Lien}}) 
                              <form action="{{route('AyantsDroit.destroy',$AyantDroit->id)}}" method='POST' style='display: inline-block;' onsubmit='return confirm("Etez -vous sur de cette Operation ?")'>
                                                   
                                     {{csrf_field()}}
                                     {{method_field('DELETE')}}
                                  <button style="border: none;"><i class="fas fa-trash"></i></button>
                              </form> 

                              <a href="{{route('AyantsDroit.edit',$AyantDroit->id)}}"><i class='fas fa-edit'></i></a>

                              <button style="border: none;" value="{{$AyantDroit->id}}" onclick="thisAyantDroit(this)" data-toggle="modal" data-target="#registre_mvt_affilier">
                                  <i class='fa fa-plus'></i>
                               </button>
                            </li>
                          @endif  
                        @endforeach
                    </ol>
                </div>  
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
                            NIVEAU DE COUVERTURE
              </div>
           <div class="card-body">
                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            @if(session()->get('Profil') == 'User')
                                            <th>Cotisation M</th>
                                           @endif        
                                            <th>Soins Ambulatoire</th>
                                            <th>Hospitalisation avec Plafond Chambre</th>
                                            <th>Unité Maternité</th>
                                            <th>Medicaments</th>
                                            <th>Lunettes</th>
                                            <th>dents</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                          @if(session()->get('Profil') == 'User')
                                            <td>
                                              <button style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopupHistoriqueCotisation(this); return false;" value="{{$Affilier->id}}" style="text-align:right">{{ $Affilier->CotisationM}}</button>
                                            </td>
                                          @endif    
                                            <td>{{ $Affilier->SoinsAmbilatoire}} %</td>
                                            <td>{{ $Affilier->PlafondChambre}} % de la Facture Global avec Plafond Chambre {{ $Affilier->PCNuit }} FBU</td>
                                            <td> TOTAL {{ $Affilier->UniteMaternite}} Si non < {{ $Affilier->UniteMaternite}} ,

                                               {{ $Affilier->ElseUniteMaternite}} % 
                                            </td>
                                            <td>{{ $Affilier->Medicament}} FBU</td>
                                            <td>{{ $Affilier->Lunette}} FBU</td>
                                            <td>{{ $Affilier->dents}} FBU</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
        
@if(session()->get('Profil') == 'User')                
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                             LISTE DES PARTENAIRES ACCESSIBLE
                        </div>
                       <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Partenaire</th>
                                            <th>Type</th>
                                            <th >Service</th>
                                            <th>Enregistré Le:</th>
                                            <th>Appliqué a:</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($Partenaires as $P)    
                                     <tr class="odd gradeX">
            <form method="POST" action="{{ route('AffilierPatenerD')}}">
                {{ csrf_field() }}
                 {{ method_field('PUT') }}
                <input type="hidden" name="Partenaire" class="form-control" value="{{$P->id}}" width="10%">
                <!--td style="display: none;"><input type="text" name="Service" class="form-control" value="{{$P->SAP}}" width="10%"></td-->
                <td>{{$P->Partenaire}}</td>
                <td>{{$P->Type}}</td>
                <input type="hidden" name="Affilier" class="form-control" value="{{$id}}" width="10%">
                <td class="center">
                    <select class="form-control" name="Service">
                         <option value="{{$P->SAP}}">{{ $P->Service}}</option>
                         <option value="All">Tous Les services</option>
                    </select>
                    
                </td>
                <td class="center">{{$P->created_at}}</td>
                <td>
                    <select name="Groupe">
                        <option value="Moimeme">Moi meme</option>
                        <option value="{{ $Origine->id}}">{{ $Origine->Origine }}</option>
                    </select>
                </td>  
                <td style="text-align: center;">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </td> 
            </form>
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

    <div class="col-md-12">
                 <div class="card">
                        <div class="card-header">
                             LISTE DES PARTENAIRES
                        </div>
                        <div class="card-body">
                <table id="example1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>Partenaire</th>
                                            <th>Type</th>
                                            <th style="display: none;">Affilier</th>
                                            <th>Type de Traitement:</th>
                                            <th>Enregistré Le:</th>
                                            <th>Appliqué a:</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($PartNonAccess as $PN)    
                                     <tr class="odd gradeX">
            <form method="POST" action="{{ route('AffilierPartenaire')}}">
                {{ csrf_field() }}
                <td style="display: none;"><input type="text" name="Partenaire" class="form-control" value="{{$PN->id}}" width="10%"></td>
                <td>{{$PN->Partenaire}}</td>
                <td>{{$PN->Type}}</td>
                <td style="display: none;"><input type="text" name="Affilier" class="form-control" value="{{$id}}" width="10%"></td>

                <td>
                      <select class="form-control" name="Service">
                        <option value="Tout">Tout le filtre</option>
                        @foreach($ServiceAff as $ServiceAf)
                         <option value="{{ $ServiceAf->id }}">{{ $ServiceAf->service }}</option>
                        @endforeach
                      </select>
                </td>

                <td class="center">{{$PN->created_at}}</td>
                <td>
                    <select name="Groupe">
                        <option value="Moimeme">Moi meme</option>
                        <option value="{{ $Origine->id}}">{{ $Origine->Origine }}</option>
                    </select>
                </td> 
                <td style="text-align: center;">
                <button type="submit" class="btn btn-primary" name="Ajouter">Ajouter</button>
                <!--  <button type="submit" class="btn btn-danger" name="Supprimer">Supprimer</button> -->
                </td> 
            </form>
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
@endif            
                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->


  <div class="modal fade" id="registre_mvt_affilier">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title">MOUVEMENT</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('mouvement_affilier.store')}}" method="POST"> 
                 {{ csrf_field() }} 
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                      <div class="form-group" style="display: none;">
                       <input type="text" class="form-control" name="beneficiaire" id="idAff">
                       <input type="text" class="form-control" name="beneficiaire_type" value="2">
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




        <div class="modal fade" id="ajout_beneficiaire_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">AJOUT DES BENEFICIAIRE POUR L'AFFILIER {{$Affilier->Nom}} {{$Affilier->Prenom}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('AyantsDroit.store')}}">
                  {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                      <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Code *</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">{{$Affilier->Code}}.</span>
                                    </div>
                                    <input type="text" class="form-control" name="Code" value="{{ old('Code')}}">
                                    {!! $errors->first('Code', '<span class="error">:message</span>') !!}
                                  </div>
                                </div>


                                <div class="form-group">
                                    <label>Nom</label>
                                    <input class="form-control" placeholder="Nom" name="Nom" value="{{ old('Nom')}}"/>
                                    {!! $errors->first('Nom', '<span class="error">:message</span>') !!}
                                </div>
                               <input type="text" name="Affilier" value="{{$Affilier->id}}" style="display: none;">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Valider l'Action</button>
                                </div>
                              </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Prenom</label>
                                <input class="form-control" placeholder="Prenom" name="Prenom" value="{{ old('Prenom')}}"/>
                                {!! $errors->first('Prenom', '<span class="error">:message</span>') !!}
                              </div>

                              <div class="form-group">
                                <label>Lien</label>
                                 <select class="form-control" name="Lien">
                                    <option onclick="AutreLienFermer()" value="Epoux">Epoux</option>
                                    <option onclick="AutreLienFermer()" value="Epouse">Epouse</option>
                                    <option onclick="AutreLienFermer()" value="Fils (Fille)">Fils (Fille)</option>
                                    <option onclick="AutreLien()">Autres</option>
                                 </select>

                                {!! $errors->first('Lien', '<span class="error">:message</span>') !!}
                              </div>

                              <div class="form-group" style="display: none;" id="Autres">
                                <input class="form-control" placeholder="Autres Lien" name="LienA" value="{{ old('LienA') }}" />
                                {!! $errors->first('LienA', '<span class="error">:message</span>') !!}
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


<!--div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title">IMPORTER UN FICHIER EXCEL DES AYANTS DROIT POUR L'AFFILIE ACTIF</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{route('uplodaAyantDroit')}}" enctype="multipart/form-data" onsubmit='return confirm("Etez - vous sur de cette Operation ?")'>
                {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">

                      <div class="col-md-12"></div>

                      <div class="col-md-12" style="display: none;">
                        <div class="form-group">
                          <label>ID *</label>
                            <input type="text" name="Affilier" class="form-control" value="{{$Affilier->id}}" id="Affilier">
                          {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                        </div>
                      </div>


                      <div style="" class="col-md-12" id="uploadForm">
                        <div class="form-group">
                          <label>Fichier Excel *</label>
                            <input type="file" name="fichier" class="form-control">
                          {!! $errors->first('fichier', '<span class="error">:message</span>') !!}
                        </div>
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
        </div>
      </div-->   
         
@endsection 


<script type="text/javascript">
        function RefreshParent() {
            if (window.opener != null && !window.opener.closed) {
                window.opener.location.reload();
            }
        }
        window.onbeforeunload = RefreshParent;
  

  var WindowObjectReference = null; // variable globale
function openFFPromotionPopupFicheAdhesion(va) {
     var id = $(va).val();
     var url = "{{ route('FicheAdhesion', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "width=200,height=900,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}

function openFFPromotionPopupCarteAdhesion(va) {
     var id = $(va).val();
     var url = "{{ route('CarteAdhesion', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "width=200,height=500,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}

function openFFPromotionPopupHistoriqueCotisation(va) {
     var id = $(va).val();
     var url = "{{ route('historiquecotisationM', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "width=200,height=500,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}

  function AutreLien()
  {
    document.getElementById("Autres").style.display = 'flex';
    //document.getElementById("FormAjoutClient").style.display = 'none';
  }

  function AutreLienFermer()
  {
    document.getElementById("Autres").style.display = 'none';
  }

    function research(va){
     var affilie= $(va).val();
     // var id_categorie= $("#Categorie").val();
      $.get('{{ route('researchAffilierCotisation') }}',
          {affilie:affilie},
          function(data){
            $("#prodReas").css('display','block');
            $('#Produit').html(data);
          });
   }

 function thisAyantDroit(va){
    var aff = $(va).val();
    var type_ben = 2;
    $('#idAff').val(aff);
    var route = "{{ route('beneficiairestatus', ['aff'=>":aff", 'type_ben'=>":type_ben"])}}";
     route = route.replace(':aff', aff);
     route = route.replace(':type_ben', type_ben);
     $.get(route,
          function(data){
            $('#statu').html(data);
    });
  }   
</script>