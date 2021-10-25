@extends('layout.base', ['title' => 'Assurance - Immobilier'])

@section('content')
  <div class="content-wrapper">
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">

                  <div><span style="font-weight: bold;">Type de Bien : </span>{{$B->Type}}</div>

                  <div><span style="font-weight: bold;">Compte Dotation : </span>{{$DotatCsubd->NumeroCompte}}/{{$DotatCsubd->Intitule}}</div>

                  <div><span style="font-weight: bold;">Sous Compte Dotation : </span>{{$DotatSC->NumeroCompte}}/{{$DotatSC->Intitule}}</div>

                  <div><span style="font-weight: bold;">Compte Ammortissement : </span>{{$AmmortCsubd->NumeroCompte}}/{{$AmmortCsubd->Intitule}}</div>

                  <div><span style="font-weight: bold;">Sous Compte Ammortissement : </span>{{$AmmortSC->NumeroCompte}}/{{$AmmortSC->Intitule}}</div>

                </h3>
              </div>


              <div class="row" style="padding: 10px;">
                  <div class="col-md-8">
                     
                    <div><span style="font-weight: bold;">Désignation de L'immobilisation : </span>{{$B->Nom}}</div>

                    <div><span style="font-weight: bold;">Provenance : </span>{{$B->Provenance}}</div>

                     <div><span style="font-weight: bold;">Durée probable de vie : </span>{{$B->Duree}} ans</div>

                    <div><span style="font-weight: bold;">Taux : </span>{{$B->Taux}} %</div>

                    <div><span style="font-weight: bold;">Methode : </span>{{$B->Methode}}</div>


                  </div>
                 

                   <div class="col-md-4">
                     
                    <div><span style="font-weight: bold;"> Date Acquisition : </span>{{$B->Date_acquis}}</div>

                    <div><span style="font-weight: bold;"> Mis en Service : </span>{{$B->Mis_service}}</div>

                    <div><span style="font-weight: bold;"> Moyen Acquisition : </span>{{$B->Moyen_acquis}}</div>

                    <div><span style="font-weight: bold;">Cout Acquisition : </span>
                      <?php echo number_format($B->Montant,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                    </div>
                  </div>
                </div><hr />

              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                  <tr>
                                            <th>#</th>
                                            <th>Bien</th>
                                            <th>Base de Calcul</th>
                                            <th>Date Début</th>
                                            <th>Date Fin</th>
                                            <th>Montant de L'amortisement</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                      {!! $TableListe !!}
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
@endsection 