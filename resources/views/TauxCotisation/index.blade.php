@extends('layout.base', ['title' => 'Assurance - Liste des Cotisation'])
@section('content')
 <div class="content-wrapper">
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
                <form method="POST" action="{{route('Taux_cotisation.store')}}" enctype="multipart/form-data" onsubmit='return confirm("Etez - vous sur de cette Operation ?")'>
                {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">

                      <div class="col-md-6">
                        <label>Taux de Cotisation</label>
                          <div class="form-inline">
                            Forfaitaire (0) <input type="radio" name="action" class="form-control" value="0" checked="checked" onclick="showForfaitaireform();"> 
                          </div>
                          
                          <div class="form-inline">
                            Nombre Personne Charge (1)<input type="radio" name="action" class="form-control" value="1" onclick="showNombrePersonneChargeform();"> 
                          </div>

                          <div class="form-inline">
                            Pourcentage revenu (2)<input type="radio" name="action" class="form-control" value="2" onclick="showPourcentagerevenuform();">
                          </div>
                      </div>


                      <div class="col-md-6" id="Forfaitaire">
                        <div class="form-group">
                          <label>Montant fixe Pour toutes les familles (param 1)*</label>
                            <input type="number" name="MontantForfaitaire" class="form-control" value="{{old('MontantForfaitaire')}}" placeholder="Indiquez un Montant fixe pour toutes les familles">
                          {!! $errors->first('MontantForfaitaire', '<span class="error">:message</span>') !!}
                        </div>
                      </div>


                      <div class="col-md-6" id="PersonneCharge" style="display: none;">
                        <div class="form-group">
                          <label>Montant unitaire par personne en charge (param 1)*</label>
                            <input type="number" name="MontantPersonneCharge" class="form-control" value="{{old('MontantPersonneCharge')}}" placeholder="Indiquez un Montant unitaire par personne en charge">
                          {!! $errors->first('MontantPersonneCharge', '<span class="error">:message</span>') !!}
                        </div>
                         <div class="form-group">
                          <label>Montant Pour le Bénéficiaire (param 2)*</label>
                            <input type="number" name="MontantBeneficiaire" class="form-control" value="{{old('MontantBeneficiaire')}}" placeholder="Indiquez un Montant Pour le Bénéficiaire">
                          {!! $errors->first('MontantBeneficiaire', '<span class="error">:message</span>') !!}
                        </div>
                      </div>

                       <div class="col-md-6" id="Pourcentage" style="display: none;">
                        <div class="form-group">
                          <label>Pourcentage a appliquer sur le revenu (param 1)*</label>
                            <input type="number" name="Pourcentage" class="form-control" value="{{old('Pourcentage')}}" placeholder="Indiquez un Pourcentage a appliquer sur le revenu" min="0" max="100">
                          {!! $errors->first('Pourcentage', '<span class="error">:message</span>') !!}
                        </div>
                      </div>
                      
                     
                      <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success swalDefaultSuccess" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-save"></i> Valider L'action</button>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <div class="card-footer">
                          <table class="table table-striped">
                           <thead>
                              <tr>
                                  <th>Taux</th>
                                  <th>Param 1</th>
                                  <th>Param 2</th>
                                  <th>Année</th>
                                  @if($TauxUsed==0)
                                  <th>Action</th>
                                  @endif
                              </tr>
                            </thead>
                            <tbody>
                          @foreach($Tauxcotisations as $Tauxcotisation)
                          <tr>
                            <td>{{$Tauxcotisation->param_taux}}</td>
                            <td>{{$Tauxcotisation->param1}}</td>
                            <td>{{$Tauxcotisation->param2}}</td>
                            <td>{{$Tauxcotisation->param_annee}}</td>
                            @if($TauxUsed==0)
                            <td><i class="fas fa-edit"></i></td>
                            @endif
                          </tr>
                          @endforeach
                           </tbody>
                        </table>
                        </div>
                      </div>

                    </div>
                  </div>

              </form>
              </div>
          </div>
                    <!--End Advanced Tables -->
        </div>
      </div>
  </section>
</div>
             <!-- /. PAGE INNER  -->
@endsection 

<script type="text/javascript">
  function showForfaitaireform()
  {
    document.getElementById("Forfaitaire").style.display = 'block';
    document.getElementById("PersonneCharge").style.display = 'none';
    document.getElementById("Pourcentage").style.display = 'none';
  }

  function showNombrePersonneChargeform()
  {
    document.getElementById("Forfaitaire").style.display = 'none';
    document.getElementById("PersonneCharge").style.display = 'block';
    document.getElementById("Pourcentage").style.display = 'none';
  }
  
  function showPourcentagerevenuform()
  {
    document.getElementById("Forfaitaire").style.display = 'none';
    document.getElementById("PersonneCharge").style.display = 'none';
    document.getElementById("Pourcentage").style.display = 'block';
  }
</script>