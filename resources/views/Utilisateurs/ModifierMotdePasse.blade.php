 @extends('layout.base', ['title' => 'Assurance - Profil Utilisateur'])
@section('content')
 <!-- /. NAV SIDE  -->
<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
        <h2 style="color: blue;font-weight: bold;">PROFIL UTILISATEUR</h2>  
            <h5>Modification du Profil</h5>
        </div>
    </div>
     <!-- /. ROW  -->
     <hr />
   <div class="row">
    <div class="col-md-12">
        <!-- Form Elements -->
        <div class="panel panel-default">
            <div class="panel-heading">
                             Mofication du Profil
                        </div>
                   
                </div>
          
            <div class="panel-body">
                <div class="row">
                       <form method="POST" action="{{ route('updateProfil', session()->get('id')) }}">
                               {{ csrf_field() }}
                               {{ method_field('PUT') }}
                            <div class="col-md-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="disabledSelect">
                                       Ancien Mot de Passe 
                                    </label>
                                    <input class="form-control"  type="password"  name="HoldPasseWord"/>

                                    {!! $errors->first('HoldPasseWord', '<span class="error">:message</span>') !!}
                                </div>

                                <div class="form-group">
                                    <label for="disabledSelect">Nouveau Mot de Passe
                                    </label>
                                    <input class="form-control"  type="password" name="NewPassword"/>

                                    {!! $errors->first('NewPassword', '<span class="error">:message</span>') !!}
                                </div>

                                <div class="form-group">
                                    <label for="disabledSelect"> Confirmer Nouveau Mot de Passe
                                    </label>
                                    <input class="form-control"  type="password" name="ConfirmNewPassword"/>

                                    {!! $errors->first('ConfirmNewPassword', '<span class="error">:message</span>') !!}
                                </div>

                                <div class="form-group">
                                    
                                    <input class="btn btn-info"  type="submit" value="Enregistrer"  />
                                </div>
                            </fieldset>
                        </div>
                        </form>
@stop