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

                                         <div class="col-12">
                         <!--                  <form method="POST" action=" {{route('getSolde')}}">  
                                          {{ csrf_field() }}
                                            <div class="row">
                                              <input type="text" name="sc_compte" id="sc_compte" style="display: none;">

                                                <input type="text" name="Csubdiv" id="Csubdiv" style="display: none;">
                                              <div class="col-5">
                                                 <div class="form-group">
                                                    <label>Compte.</label>
                                                    <select class="form-control select2" required="" name="Compte">
                                                      <option></option>
                                                      @foreach($ComptePrincipals as $ComptePrincipal)
                                                        <option value="{{$ComptePrincipal->id}}">{{$ComptePrincipal->NumeroCompte}} -- {{$ComptePrincipal->Intitule}}</option>
                                                      @endforeach  
                                                   </select>
                                                   {!! $errors->first('Compte', '<span class="error">:message</span>') !!}
                                                 </div>
                                              </div>

                                        
                                              <div class="col-5">
                                                  <div class="form-group">
                                                    <label>Solde du .</label>
                                                   <input type="date" id="hue-demo" class="form-control" data-control="hue" required="" name="Montant" value="">
                                                    {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
                                                 </div> 
                                              </div>

                                              <div class="col-2">
                                                  <div class="form-group">
                                                   <button style="margin-top: 30px;" type="submit" class="form-control btn btn-success">Filtrer</button>
                                                 </div> 
                                              </div>
                                          </div>
                                      </form>  -->

                                           <div class="col-4"><a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                                            <i class="ti-plus"></i>Solder.
                                            </a></div>

                                        </div>
                                  </div><hr>
                                 

                                  <div class="table-responsive">
                                   <div class="col-12">
                                    <table id="zero_config" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>N° des comptes</th>
                                                <th>Date Operation</th>
                                                <th>Transferer Au</th>
                                                <th>Montants</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Soldes as $Solde)
                                              <tr>
                                                <td><a href="{{route('solde_detail', [$Solde->id,$Solde->dateOperation])}}">{{$Solde->NumeroCompte}}{{$Solde->Intitule}}</a></td>
                                                <td>{{$Solde->dateOperation}}</td>
                                                <td>{{$Solde->repporterAu}}</td>
                                                <td><?php echo number_format($Solde->montant,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?></td>
                                              </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            
            <!-- Modal Add Category -->
                <div class="modal fade none-border" id="add-new-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                         
                      <form method="POST" action="{{ route('SoldeJour.store')}}" name="P_form">
                            <div class="modal-body" >
                      {{ csrf_field() }}
                        <div class="row">
                          <div class="col-md-12">
                        <label>Compte *</label>
                        <div class="form-inline">
                          <select class="form-control select2" name="Compte" target="PromoteFirefoxWindowName" onchange="openSComptesPopUp(this); return false;" style="width: 100%">
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
                            </div>

                          <div class="col-6">
                             <div class="form-group">
                                                    <label>Solde du .</label>
                                                   <input type="date" id="hue-demo" class="form-control" data-control="hue" required="" name="SoldeOutcome" value="">
                                                    {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
                                                 </div> 
                          </div>  


                          <div class="col-6">
                             <div class="form-group">
                                                    <label>Solder Au .</label>
                                                   <input type="date" id="hue-demo" class="form-control" data-control="hue" required="" name="SoldeIncome" value="">
                                                    {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
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



                     @endsection                      
@section('content2')
<script type="text/javascript">
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

</script>
@endsection