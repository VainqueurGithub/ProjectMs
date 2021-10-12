@extends('layout.base', ['title' => 'Assurance - Corbeille Factures'])

@section('content')
              <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-12">
                    <h2 style="color: red;font-weight: bold;text-align: center;">LISTE DES FACTURES SUPPRIMEES</h2>   
                       
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Liste des Factures Supprimées 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>N° Facture</th>
                                            <th>D.Traitement</th>
                                            <th>Affilier</th>
                                            <th>Béneficiaire</th>
                                            <th>D.Transmission</th>
                                            <th>Partenaire</th>
                                            <th>Montant</th>
                                            <th>D.Payement</th>
                                            <th>M.Payement</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      {!! $tableListe !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </div>
               
    </div>
             <!-- /. PAGE INNER  -->
@endsection 
