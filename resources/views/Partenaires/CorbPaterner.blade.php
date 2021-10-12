@extends('layout.base', ['title' => 'Assurance - Corbeille Partenaire'])

@section('content')
              <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-12">
                    <h2 style="color: red;font-weight: bold;text-align: center;">LISTE DES PARTENAIRES SUPPRIMES</h2>   
                       
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Liste des Partenaires Supprimés
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Partenaire</th>
                                            <th>Type</th>
                                            <th>Adhesion Minimum</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                     @foreach ($Partenaires as $Partenaire)

                                         <tr class="odd gradeX">
                                            <td>{{ $Partenaire->Code }}</td>
                                            <td>{{ $Partenaire->Partenaire }}</td>
                                            <td>{{ $Partenaire->Type }}</td>
                                            <td>{{ $Partenaire->AdhesionMin }}</td>
                                             <td>
                                               <a href="{{ route('RestaurePaterner', $Partenaire) }}"><img src="{{ url('icons/icons8_Reset_24px.png') }}" width="20px" height="20px"></a>
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
        </div>
               
    </div>
             <!-- /. PAGE INNER  -->
@endsection 
