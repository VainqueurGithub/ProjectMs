@extends('layout.base', ['title' => 'Assurance - Corbeille Cotisation'])

@section('content')
              <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-12">
                    <h2 style="color: red;font-weight: bold;text-align: center;">LISTE DES COTISATION SUPPRIMEES</h2>   
                       
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
                
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Liste des Cotisations Supprimées
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>ADHERANT</th>
                                            <th>MOIS</th>
                                            <th>ANNEE</th>
                                            <th>MONTANT</th>
                                            <th>ACTION</th>
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
