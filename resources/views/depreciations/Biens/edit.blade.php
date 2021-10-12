@extends('layout.base', ['title' => 'Assurance - Immobilier'])

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
          <div class="modal-body">
                <form method="POST" action="{{route('Bien.update', $Bien->Bid)}}" onsubmit='return confirm("Etez - vous sur de cette Operation ?")' name="P_form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                  <div class="panel-body">
                    <div class="table-responsive">
                       <div class="form-group">
                          <label>Type d'immobilier*</label>
                           <select class="form-control select2" name="Type">
                              <option value="{{$Bien->id}}">{{$Bien->Type}}</option>
                              @foreach($Depreciationtype as $Depreciation)
                                 <option value="{{$Depreciation->id}}">{{$Depreciation->Type}}</option>
                              @endforeach
                           </select>
                          {!! $errors->first('Type', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                         <label>Nom *</label>
                           <input type="text" class="form-control" name="Nom" value="{{$Bien->Nom}}" />
                          {!! $errors->first('Nom', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Date Acquisition *</label>
                           <input type="date" class="form-control" name="Dateacquis" value="{{$Bien->Date_acquis}}" />
                           {!! $errors->first('Dateacquis', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Moyen Acquisition *</label>
                          <select class="form-control select2" name="Moyen">
                             <option value="{{$Bien->Moyen_acquis}}">{{$Bien->Moyen_acquis}}</option>
                             <option value="Achat">Achat</option>
                             <option value="Don">Don</option>
                             <option value="Leg">Don</option>
                          </select>
                          {!! $errors->first('Moyen', '<span class="error">:message</span>') !!}
                        </div>
                        
                        <div class="form-group">
                          <label>Date Production *</label>
                           <input type="date" class="form-control" name="Misservice" value="{{$Bien->Mis_service}}" />
                           {!! $errors->first('Misservice', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Montant Acquisition *</label>
                           <input type="number" class="form-control" name="Montant" value="{{$Bien->Montant}}" />
                           {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Provenance </label>
                           <input type="text" class="form-control" name="Provenance" value="{{$Bien->Provenance}}" />
                           {!! $errors->first('Provenance', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Durée *</label>
                           <input type="number" class="form-control" name="Duree" value="{{$Bien->Duree}}" id="duree" oninput="getDuree(this)" />
                           {!! $errors->first('Duree', '<span class="error">:message</span>') !!}
                        </div>

                         <div class="form-group">
                          <label>Taux *</label>
                           <input type="number" class="form-control" name="Taux" value="{{$Bien->Taux}}" readonly="readonly" id="Taux" />
                           {!! $errors->first('Taux', '<span class="error">:message</span>') !!}
                        </div>

                        <div class="form-group">
                          <label>Methode Amortissement *</label>
                           <select class="form-control select2" name="Methode">
                             <option value="{{$Bien->Methode}}">{{$Bien->Methode}}</option>
                             <option value="Lineaire">Lineaire</option>
                             <option value="Progressif">Progressif</option>
                             <option value="Variable">Variable</option>
                          </select>
                           {!! $errors->first('Duree', '<span class="error">:message</span>') !!}
                        </div>

                            </div>
                        </div>

                        <label>Dotations aux amortissements *</label>
                        <div class="form-inline">
                          <select class="form-control select2" name="Comptabilite1" target="PromoteFirefoxWindowName" onchange="openSComptesPopUp(this); return false;" style="width: 100%">
                            @if(!is_null($CompteSubd1))
                            <option value="{{$CompteSubd1->id}}">{{$CompteSubd1->NumeroCompte}} -- {{$CompteSubd1->Intitule}}</option>
                            @endif
                            @foreach($Scomptes as $Scompte)
                             <option value="{{$Scompte->id}}">{{$Scompte->NumeroCompte}} - {{$Scompte->Intitule}}</option>
                            @endforeach 
                          </select>

                          @if(!is_null($Scomptes1))
                          <input type="text" name="sccomte_int1" value="{{$Scomptes1->NumeroCompte}} -- {{$Scomptes1->Intitule}}" class="form-control" style="border: none;width:80%;" readonly=""><span target="PromoteFirefoxWindowName" onclick="hideSousComptes1(); return false;"><i class="fas fa-trash"></i></span>
                          @endif
                        </div>

                       <div class="col-4" id="sccomte_int1" style="display: none;">
                         @if(!is_null($Scomptes1))
                         <input type="text" name="sc_compte1" id="sc_compte1" value="{{$Scomptes1->id}}" style="display: none;">
                         @endif

                         @if(!is_null($CompteSubd1))
                         <input type="text" name="Csubdiv1" id="Csubdiv1" value="{{$CompteSubd1->id}}" style="display: none;">
                         @endif
                      </div>


                        <label>Amortissements *</label>
                        <div class="form-inline">
                          <select class="form-control select2" name="Comptabilite2" target="PromoteFirefoxWindowName" onchange="openSComptesPopUp1(this); return false;" style="width: 100%">
                            @if(!is_null($CompteSubd2))
                            <option value="{{$CompteSubd2->id}}">{{$CompteSubd2->NumeroCompte}} -- {{$CompteSubd2->Intitule}}</option>
                            @endif
                            @foreach($Scomptes as $Scompte)
                             <option value="{{$Scompte->id}}">{{$Scompte->NumeroCompte}} - {{$Scompte->Intitule}}</option>
                            @endforeach 
                          </select>

                          @if(!is_null($Scomptes2))
                          <input type="text" name="sccomte_int2" value="{{$Scomptes2->NumeroCompte}} -- {{$Scomptes2->Intitule}}" class="form-control" style="border: none;width:80%;" readonly=""><span target="PromoteFirefoxWindowName" onclick="hideSousComptes2(); return false;"><i class="fas fa-trash"></i></span>
                          @endif
                        </div>  
                        
                        <div class="col-4" id="sccomte_int2" style="display: none;">
                          @if(!is_null($Scomptes2))
                         <input type="text" name="sc_compte2" id="sc_compte2" value="{{$Scomptes2->id}}" style="display: none;">
                         @endif
                          @if(!is_null($CompteSubd2))
                         <input type="text" name="Csubdiv2" id="Csubdiv2" value="{{$CompteSubd2->id}}" style="display: none;">
                         @endif

                            </div>  
                        </div>
                
                 <div class="modal-footer justify-content-between">
                    <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success swalDefaultSuccess" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-save"></i> Modifier</button>
                        </div>
                      </div>
                </div>
              </form>
            </div>
        </div>
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