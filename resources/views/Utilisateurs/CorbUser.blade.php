@extends('layout.base', ['title' => 'Assurance - Corbeille Utilisateurs'])

@section('content')
              <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-12">
                    <h2 style="color: red;font-weight: bold;text-align: center;">LISTE DES UTILISATEURS SUPPRIMES</h2>   
                       
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
                
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Liste des Utilisateurs Supprimés
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Profil</th>
                                            <th>Mail</th>
                                            <th>Date Inscription</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($Utilisateurs as $User)

                                         <tr class="odd gradeX">
                                            <td>{{ $User->Nom }}</td>
                                            <td>{{ $User->Prenom }}</td>
                                            <td>{{ $User->Profil }}</td>
                                            <td>{{ $User->Email }}</td>
                                            <td>{{ $User->created_at }}</td>
                                            
                                             <td>
                                              <a href="{{ route('RestaurerUser', $User) }}"><img src="{{ url('icons/icons8_Reset_24px.png') }}" width="20px" height="20px"></a>
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
