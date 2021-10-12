@extends('layout.base', ['title' => 'Assurance - Corbeille Ayant Droit'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
               <div class="row">
                  <div class="col-md-12">
                    <h2 style="color: red;font-weight: bold;text-align: center;">LISTE DES AYANTS DROITS SUPPRIMES</h2>   
                       
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
               <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                           Liste des Ayants droits Supprimés
                        </div>
                      <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Ref</th>
                                            <th>Affilier</th>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Date Enregistrement</th>
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
                      </div>
                     </div>
                </div>
            </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
@endsection 
