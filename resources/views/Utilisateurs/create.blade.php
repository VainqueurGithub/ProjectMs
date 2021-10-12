@extends('layout.base', ['title' => 'Assurance - Nouvel Utilisateur'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
        <h2 style="color: blue;font-weight: bold;text-align: center;">Nouvel Utilisateur</h2>
        </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Ajout d'un Utilisateur
                             <a href="{{ route('Utilisateurs.index') }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-book"></i> Liste des Utilisateur
                            </a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form role="form" method="POST" action="{{ route('Utilisateurs.store')}}">
                                      {{ csrf_field() }}
                                        @include('Utilisateurs._Form', ['ButtonSubmitTexe'=>'Enregistrer'])
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                      </div>
                                     
                                    </form>
                                    <br />                    
    </div>

                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
@endsection 
