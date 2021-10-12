@extends('layout.base', ['title' => 'Assurance - Liste des Affiliers'])

@section('content')
              <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-12">
                    <h2 style="color: blue;font-weight: bold;text-align: center;">LISTE DES AFFILIERS</h2>   
                       
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
                
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Liste des Affiliers
                             <a href="{{ route('Affiliers.create') }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-plus"></i> Ajouter un Affilier
                            </a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Ref</th>
                                            <th>Code</th>
                                            <th>Adherant</th>
                                            <th>Origine</th>
                                            <th>Date Entrée</th>
                                            <th>Cot.Mens</th>
                                            <th>S.A</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($Affiliers as $Affilier)

                                         <tr class="odd gradeX">
                                            <td>{{ $Affilier->id }}</td>
                                            <td>{{ $Affilier->Code }}</td>
                                            <td>{{ $Affilier->Nom }} {{ $Affilier->Prenom }}</td>
                                            <td>{{ $Affilier->Origine }}</td>
                                            <td>{{ $Affilier->DateEntree }}</td>
                                            <td>{{ $Affilier->CotisationM }}</td>
                                            <td>{{ $Affilier->SoinsAmbilatoire }}%</td>
                                  
                                             <td>
                                               <a href="{{ route('Affiliers.edit', $Affilier) }}"><img src="{{ url('icons/icons8_Edit_26px.png') }}" width="20px" height="20px"></a>

                                                <form action="{{ route('Affiliers.destroy', $Affilier) }}" method="POST" style="display: inline-block;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                    
                                                <button><i class='fa fas-trash'></i>
                                                  </button>
                                              </form>
                                              
                                              <a href="{{ route('Affiliers.show', $Affilier) }}"><i class='fa fa-eye'></i>
                                                  </a>

                                              <a href="{{ route('AyantsDroit.create', $Affilier) }}"><i class='fa fa-plus'></i>
                                                  </a>

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
