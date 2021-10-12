@extends('layout.base', ['title' => 'Assurance - Nouvelle Facture'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-7">
                       <h2 style="color: blue;font-weight: bold;text-align: center;">Detail Facture Facture</h2>
                    </div>

                    <div class="col-md-5">
                      <form action="{{ route('Factures.destroy', $Facture) }}" method="POST" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                    
                                <button class="btn btn-danger">Supprimer
                                </button>
                               </form>

                      <a href="{{ route('Commandecreate',$Facture)}}">
                               <button class="btn btn-default">Retourner</button>
                              </a>          
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-body">
<!--                             <div class="row">
                                <form role="form" method="POST" action="{{ route('Factures.update', $Facture)}}">
                                      {{ csrf_field() }}
                                      {{ method_field('PUT') }}
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Affilier</label>
                                            <select class="form-control" name="Affilier">
                                              <option value="{{ $Affilier->id}}"> {{ $Affilier->Code}}/{{ $Affilier->Nom}} {{ $Affilier->Prenom}}</option>
                                              @foreach($Affiliers as $Aff)
                                               <option value="{{ $Aff->id}}">{{ $Aff->Code}}/{{ $Aff->Nom}} {{ $Aff->Prenom}}</option>
                                              @endforeach
                                            </select>

                                            {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                        </div>

                                      <div class="form-inline">
                                             <label>Type de Traitement* : </label>

                                        @if($AffilierPartenaire->SA==1 AND $AffilierPartenaire->Hospitalisation==1 AND $AffilierPartenaire->Maternite==1)     
                                            Soins Ambulatoire <input type="radio" required="required" class="form-control" name="TraitementT" value="1"/> 
                                        
                                            Hospitalisation <input type="radio" required="required" value="2" class="form-control" name="TraitementT"/> 

                                            Maternité <input type="radio" required="required" value="3" class="form-control" name="TraitementT" /> 
                                        @elseif($AffilierPartenaire->SA==1 AND $AffilierPartenaire->Hospitalisation==1)

                                          Soins Ambulatoire <input type="radio" value="1" class="form-control" required="required" name="TraitementT"/> 
                                        
                                            Hospitalisation <input type="radio" value="2" class="form-control" required="required" name="TraitementT"/> 
                                        
                                        @elseif($AffilierPartenaire->SA==1 AND $AffilierPartenaire->Maternite==1)

                                         Soins Ambulatoire <input type="radio" value="1" class="form-control" required="required" name="TraitementT"/> 
                                        
                                            Maternité <input type="radio" value="3" class="form-control" required="required" name="TraitementT"/> 
                                        @elseif($AffilierPartenaire->Hospitalisation==1 AND $AffilierPartenaire->Maternite==1)

                                        Hospitalisation <input type="radio" value="2" class="form-control" required="required" name="TraitementT"/> 
                                        
                                            Maternité <input type="radio" value="3" class="form-control" required="required" name="TraitementT"/> 

                                            @elseif($AffilierPartenaire->SA==1)

                                         Soins Ambulatoire <input type="radio" required="required" value="1" class="form-control" name="TraitementT"/>     
                                        @elseif($AffilierPartenaire->Hospitalisation==1)

                                         Hospitalisation <input type="radio" required="required" value="2" class="form-control" name="TraitementT"/>     
                                        @elseif($AffilierPartenaire->Maternite==1)

                                         Maternité <input type="radio" required="required" value="3" class="form-control" name="TraitementT"/>     
                                        @endif        
                                        </div>


                                        <div class="form-group">
                                            <label>Beneficiaire</label>
                                           <select class="form-control" name="AyantDroits">
                                              <option value="{{ $AyantDroit->id}}"> {{ $AyantDroit->Nom}} {{ $AyantDroit->Prenom}}</option>
                                              @foreach($AyantDroits as $ADroit)
                                               <option value="{{ $ADroit->id}}">{{ $ADroit->Nom}} {{ $ADroit->Prenom}}</option>
                                              @endforeach
                                            </select>

                                            {!! $errors->first('AyantDroits', '<span class="error">:message</span>') !!}
                                        </div>

        
                                       <label></label><br>
                                        <button type="submit" name="Suivant" class="btn btn-primary">Modifier</button>

                                      
                                      </div>
                                      
                                      <div class="col-md-6">
                                       @if(session()->get('Profil') =='User') 
                                         <div class="form-group">
                                            <label>Partenaire</label>
                                            <select class="form-control" name="Partenaire">
                                              <option value="{{ $Partenaire->id}}"> {{ $Partenaire->Partenaire}}</option>
                                              @foreach($Partenaires as $Part)
                                               <option value="{{ $Part->id}}">{{ $Part->Partenaire}}</option>
                                              @endforeach
                                            </select>
                                            {!! $errors->first('Partenaire', '<span class="error">:message</span>') !!}
                                        </div>
                                        @endif
                                        
                                        <div class="form-group">
                                            <label>Date Traitement</label>
                                            <input type="date" class="form-control" placeholder="Quantité" name="DateT" value="{{ $DetailsFacture->DateTraitement }}" />

                                            {!! $errors->first('DateT', '<span class="error">:message</span>') !!}
                                        </div>
                                      </div>
                                    </form>
                                    <br />                    
    </div> -->

                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>



            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <a href="{{ route('Commandecreate', $Facture) }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-plus"></i> Ajouter une Commande
                            </a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Libellé</th>
                                            <th>P.U</th>
                                            <th>Qte</th>
                                            <th>PT</th>
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
            </div>
         <!-- /. PAGE WRAPPER  -->
@endsection 

<script type="text/javascript">
   function getBeneficiaire(va){
     var id_affilier= $(va).val();

      $.get('{{ route('getProduiBenfic') }}',
          {id_affilier:id_affilier},
          function(data){
            $('#AyantDroits').html(data);
          });
   }
</script>