@extends('layout.base', ['title' => 'Assurance - Historique Prix'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
               <div class="row">
                  <div class="col-md-12">
                    <h2 style="color: blue;font-weight: bold;text-align: center;">HISTORIQUE DES PRIX LE MEDICAMENT {{ $medicaments->Code }} / {{ $medicaments->Libelle }}</h2>    
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
               <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                      <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Medicament</th>
                                            <th>Prix</th>
                                            <th>Fin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($results as $result) 
                                        <tr>
                                          <td>{{$result->code}}</td>
                                          <td>{{$result->Prix}}</td>
                                          <td>{{$result->Fin}}</td>
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
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
@endsection 
