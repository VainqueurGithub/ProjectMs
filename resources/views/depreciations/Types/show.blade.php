@extends('layout.base', ['title' => 'Assurance - Immobilier'])

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <h3>Liste des Immobiliers</h3>
        </div>
      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Immobiliers</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                      <div class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-sm"  style="margin-top: -5px">
                          <i class="fa fa-plus"></i> Ajouter un immobilier
                      </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                            <th>Nom</th>
                                            <th>Acquis Le</th>
                                            <th>Acquis Par</th>
                                            <th>Mise en service</th>
                                            <th>Montant</th>
                                            <th>Durée</th>
                                            <th>Taux</th>
                                            <th>Methode</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                     @foreach ($Biens as $Bien)
                                         <tr class="odd gradeX">
                                            <td>{{ $Bien->Nom }}</td>
                                            <td>{{ $Bien->Date_acquis }}</td>
                                            <td>{{ $Bien->Moyen_acquis }}</td>
                                            <td>{{ $Bien->Mis_service }}</td>
                                            <td>{{ $Bien->Montant }}</td>
                                            <td>{{ $Bien->Duree }}</td>
                                            <td>{{ $Bien->Taux }}</td>
                                            <td>{{ $Bien->Methode }}</td>
                                            <td>
                                                <a href="{{route('Bien.edit', $Bien->id)}}"><i class="fa fa-edit"></i></a>
                                                 
                                              
                        
                                              <form action="{{ route('Bien.destroy', $Bien) }}" method="POST" style="display: inline-block;border: none;" onsubmit="return confirm('Etez -vous sur de cette Operation ?')">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                    
                                                <button><i class="fas fa-trash"></i>
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
             <!-- /. PAGE INNER  -->


<!-- MODEL POUR AJOUTER UN IMMOBILIER A LISTE DEBUT -->
   
   <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">AJOUTER UN NOUVEL IMMOBILIER </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{route('Bien.store')}}" onsubmit='return confirm("Etez - vous sur de cette Operation ?")' name="P_form">
                {{ csrf_field() }}
                  <div class="panel-body">
                    <div class="table-responsive">
                        <div class="form-group" style="display: none;">
                          <label>Type d'immobilier*</label>
                          <input type="text" name="Type" value="{{$Type}}">
                          {!! $errors->first('Type', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                         <label>Nom *</label>
                           <input type="text" class="form-control" name="Nom" value="{{ old('Nom')}}" />
                          {!! $errors->first('Nom', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Date Acquisition *</label>
                           <input type="date" class="form-control" name="Dateacquis" value="{{ old('Dateacquis')}}" />
                           {!! $errors->first('Dateacquis', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Moyen Acquisition *</label>
                          <select class="form-control select2" name="Moyen">
                             <option value="Achat">Achat</option>
                             <option value="Don">Don</option>
                             <option value="Leg">Don</option>
                          </select>
                          {!! $errors->first('Moyen', '<span class="error">:message</span>') !!}
                        </div>
                        
                        <div class="form-group">
                          <label>Date Production *</label>
                           <input type="date" class="form-control" name="Misservice" value="{{ old('Misservice')}}" />
                           {!! $errors->first('Misservice', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Montant Acquisition *</label>
                           <input type="number" class="form-control" name="Montant" value="{{ old('Montant')}}" />
                           {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Provenance </label>
                           <input type="text" class="form-control" name="Provenance" value="{{ old('Provenance')}}" />
                           {!! $errors->first('Provenance', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Durée *</label>
                           <input type="number" class="form-control" name="Duree" id="duree" oninput="getDuree(this)" value="{{ old('Duree')}}" />
                           {!! $errors->first('Duree', '<span class="error">:message</span>') !!}
                        </div>

                         <div class="form-group">
                          <label>Taux (%)*</label>
                           <input type="number" readonly="readonly" class="form-control" id="Taux" name="Taux" value="{{ old('Taux')}}" />
                           {!! $errors->first('Taux', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Methode Amortissement *</label>
                           <select class="form-control select2" name="Methode">
                             <option value="Lineaire">Lineaire</option>
                             <option value="Progressif">Progressif</option>
                             <option value="Variable">Variable</option>
                          </select>
                           {!! $errors->first('Methode', '<span class="error">:message</span>') !!}
                        </div>

                        <label>Dotations aux amortissements *</label>
                        <div class="form-inline">
                          <select class="form-control select2" name="Comptabilite1" target="PromoteFirefoxWindowName" onchange="openSComptesPopUp(this); return false;" style="width: 100%">
                            <option></option>
                            @foreach($Scomptes as $Scompte)
                             <option value="{{$Scompte->id}}">{{$Scompte->NumeroCompte}} - {{$Scompte->Intitule}}</option>
                            @endforeach 
                          </select>
                          <input type="text" name="sccomte_int1" class="form-control" style="border: none;width:80%;" readonly=""><span target="PromoteFirefoxWindowName" onclick="hideSousComptes1(); return false;"><i class="fas fa-trash"></i></span>
                        </div>

                        <div class="col-4" id="sccomte_int1" style="display: none;">
                         <input type="text" name="sc_compte1" id="sc_compte1" style="display: none;">
                         <input type="text" name="Csubdiv1" id="Csubdiv1" style="display: none;">

                            </div>


                        <label>Amortissements *</label>
                        <div class="form-inline">
                          <select class="form-control select2" name="Comptabilite2" target="PromoteFirefoxWindowName" onchange="openSComptesPopUp1(this); return false;" style="width: 100%">
                            <option></option>
                            @foreach($Scomptes as $Scompte)
                             <option value="{{$Scompte->id}}">{{$Scompte->NumeroCompte}} - {{$Scompte->Intitule}}</option>
                            @endforeach 
                          </select>
                          <input type="text" name="sccomte_int2" class="form-control" style="border: none;width:80%;" readonly=""><span target="PromoteFirefoxWindowName" onclick="hideSousComptes2(); return false;"><i class="fas fa-trash"></i></span>
                        </div> 
                        
                          <div class="col-4" id="sccomte_int2" style="display: none;">
                         <input type="text" name="sc_compte2" id="sc_compte2" style="display: none;">
                         <input type="text" name="Csubdiv2" id="Csubdiv2" style="display: none;">

                            </div>    
                        </div>
                
                 <div class="modal-footer justify-content-between">
                    <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success swalDefaultSuccess" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-save"></i> Valider L'action</button>
                        </div>
                      </div>
                </div>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div> 

    <!-- MODEL POUR AJOUTER UN IMMOBILIER A LISTE FIN -->  



    <!-- MODEL POUR MODIFIER UN IMMOBILIER A LISTE DEBUT -->
   
   <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">AJOUTER UN NOUVEL IMMOBILIER </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('Bien.store')}}" onsubmit='return confirm("Etez - vous sur de cette Operation ?")'>
                {{ csrf_field() }}
                  <div class="panel-body">
                    <div class="table-responsive">
                       <div class="form-group">
                          <label>Type d'immobilier*</label>
                          <input type="text" name="Type" value="{{$Type}}">
                          {!! $errors->first('Type', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                         <label>Nom *</label>
                           <input type="text" class="form-control" name="Nom" value="{{ old('Nom')}}" />
                          {!! $errors->first('Nom', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Date Acquisition *</label>
                           <input type="date" class="form-control" name="Dateacquis" value="{{ old('Dateacquis')}}" />
                           {!! $errors->first('Dateacquis', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Moyen Acquisition *</label>
                          <select class="form-control select2" name="Moyen">
                             <option value="Achat">Achat</option>
                             <option value="Don">Don</option>
                             <option value="Leg">Don</option>
                          </select>
                          {!! $errors->first('Moyen', '<span class="error">:message</span>') !!}
                        </div>
                        
                        <div class="form-group">
                          <label>Date Production *</label>
                           <input type="date" class="form-control" name="Misservice" value="{{ old('Misservice')}}" />
                           {!! $errors->first('Misservice', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Montant Acquisition *</label>
                           <input type="number" class="form-control" name="Montant" value="{{ old('Montant')}}" />
                           {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Provenance </label>
                           <input type="text" class="form-control" name="Provenance" value="{{ old('Provenance')}}" />
                           {!! $errors->first('Provenance', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Durée *</label>
                           <input type="number" class="form-control" name="Duree" value="{{ old('Duree')}}" />
                           {!! $errors->first('Duree', '<span class="error">:message</span>') !!}
                        </div>

                         <div class="form-group">
                          <label>Taux *</label>
                           <input type="number" class="form-control" name="Taux" value="{{ old('Taux')}}" />
                           {!! $errors->first('Taux', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Methode Amortissement *</label>
                           <select class="form-control select2" name="Methode">
                             <option value="Lineaire">Lineaire</option>
                             <option value="Progressif">Progressif</option>
                             <option value="Variable">Variable</option>
                          </select>
                           {!! $errors->first('Duree', '<span class="error">:message</span>') !!}
                        </div>

                            </div>
                        </div>
                
                 <div class="modal-footer justify-content-between">
                    <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success swalDefaultSuccess" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-save"></i> Valider L'action</button>
                        </div>
                      </div>
                </div>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div> 

    <!-- MODEL POUR MODIFIER UN IMMOBILIER A LISTE FIN -->            
@endsection 
@section('content2')
<script type="text/javascript">
  function getDuree(va){
    var Duree= $(va).val();
    var Taux = 100/Duree;
    $('#Taux').val(Taux);
  }

  var WindowObjectReference = null; // variable globale
function openSComptesPopUp(va) {
     var id = $(va).val();
     var url = "{{ route('Comptedivisionnaire.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           'rating', "width=500,height=250,left=540,top=400,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}

function openSComptesPopUp1(va){
  var id = $(va).val();
     var url = "{{ route('Amortissement_sous_compte', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           'rating', "width=500,height=250,left=540,top=400,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}

function hideSousComptes1() {
      var SousId = $('#Csubdiv1').val();
      document.P_form.sc_compte1.value = '';
      document.P_form.sccomte_int1.value = '';
      document.getElementById('sccomte_int1').style.display = 'none';
      var url = "{{ route('Comptedivisionnaire.show', ":SousId") }}";
      url = url.replace(':SousId', SousId);
      if (WindowObjectReference == null || WindowObjectReference.closed) {
        WindowObjectReference = window.open(url,'rating', "width=500,height=250,left=540,top=400,resizable,scrollbars=yes,status=1,menubar=no");
      }
      else {
        WindowObjectReference.focus();
      };
}

function hideSousComptes2() {
      var SousId = $('#Csubdiv2').val();
      document.P_form.sc_compte2.value = '';
      document.P_form.sccomte_int2.value = '';
      document.getElementById('sccomte_int2').style.display = 'none';
      var url = "{{ route('Amortissement_sous_compte', ":SousId") }}";
      url = url.replace(':SousId', SousId);
      if (WindowObjectReference == null || WindowObjectReference.closed) {
        WindowObjectReference = window.open(url,'rating', "width=500,height=250,left=540,top=400,resizable,scrollbars=yes,status=1,menubar=no");
      }
      else {
        WindowObjectReference.focus();
      };
}
</script>
@endsection