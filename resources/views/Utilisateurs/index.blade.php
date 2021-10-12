@extends('layout.base', ['title' => 'Assurance - Liste des Utilisateurs'])

@section('content')
              <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-12">
                    <h2 style="color: blue;font-weight: bold;text-align: center;">LISTE DES UTILISATEURS</h2>   
                       
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
                
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Liste des Utilisateurs
                             <a href="{{ route('Utilisateurs.create') }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-plus"></i> Ajouter un Utilisateur
                            </a>
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
                                               <a href="{{ route('Utilisateurs.edit', $User) }}"><img src="{{ url('icons/icons8_Edit_26px.png') }}" width="20px" height="20px"></a>

                                                <form action="{{ route('Utilisateurs.destroy', $User) }}" method="POST" style="display: inline-block;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                    
                                                <button><img src="{{url('icons/icons8_Delete_52px.png')}}" width='20px' height='20px'>
                                                  </button>
                                              </form>

                                              <a href="{{ route('restaureMotDePasse', $User) }}"><img src="{{ url('icons/icons8_Reset_24px.png') }}" width="20px" height="20px"></a>
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
