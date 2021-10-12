@extends('layout.base', ['title' => 'Assurance - Nouvelle Facture'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-4">
                       <h4 style="color: blue;font-weight: bold;text-align: center;border:1px solid black;padding:10px;"> Total a payer : {{ $MontantCommande}} FBU.</h4>
                    </div>

                    <div class="col-md-4">
                       <h2 style="color: blue;font-weight: bold;text-align: center;">Nouvelle Facture</h2>
                    </div>
                    
                    <div class="col-md-4" style="">
                      <a href="{{ route('Factures.show', $Facture)}}">
                       <h4 style="color: blue;font-weight: bold;text-align: center;border:1px solid black;padding:10px;">
                        Mon Panier {{ $NbreCommande}}
                       </h4>
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
                            <div class="row">
                                    <form target="blank" role="form" method="POST" action="{{ route('Commandes.store')}}">
                                      {{ csrf_field() }}
                                      <div class="col-md-6">

                                        <div class="form-group" style="display: none;">
                                            <label>Facture*</label>
                                            <input class="form-control" name="Facture" value="{{ $Facture }}" />

                                            {!! $errors->first('Facture', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Service *</label>
                                            <select class="form-control" name="Libelle">
                                              @foreach($Services as $Service)
                                              <option value="{{ $Service->id }}">{{$Service->service}}</option>
                                              @endforeach
                                            </select>
                                          
                                            {!! $errors->first('Libelle', '<span class="error">:message</span>') !!}
                                        </div>


                                <div class="form-group">
                                    <label>Libellé *</label>
                                    <input type="text" name="prodReas" id="prodReas"  class="form-control" style="" oninput="research(this)">
                                    <select class="form-control" name="Propriete" id="Produit">
                                        <option></option>
                                    </select>
                                    {!! $errors->first('Propriete', '<span class="error">:message</span>') !!}
                                </div>

                                        <div class="form-group">
                                            <label>Quantité</label>
                                            <input type="number" class="form-control" placeholder="Quantité" name="Quantite" value="{{ old('Quantite') }}" min="1" />

                                            {!! $errors->first('Quantite', '<span class="error">:message</span>') !!}
                                        </div>
                                     
                                     <!-- AFFICHER SES OPTIONS QUE SI LE TYPE DE SERVICE EST HOSPITALISATION -->
                                           
                                       @if($Service->Traitement==2 AND $NbreSejour==0)
                                        <div class="form-inline">
                                            <label>Marquer Sejour</label>
                                            <input type="radio" required="" class="form-control"  name="Sejour" value="1"/>

                                            <label>Annuler Sejour</label>
                                            <input type="radio" required="" class="form-control"  name="Sejour" value="0"/>

                                            {!! $errors->first('Sejour', '<span class="error">:message</span>') !!}
                                        </div>
                                        @else
                                          <div class="form-inline" style="display: none;">
                                            <label>Marquer Sejour</label>
                                            <input type="radio" checked="" class="form-control"  name="Sejour" value="0"/>
                                            {!! $errors->first('Sejour', '<span class="error">:message</span>') !!}
                                        </div>
                                        @endif
                                
                                      
                                       <label></label><br>
                                        <button type="submit" name="Suivant" class="btn btn-primary">Enregistrer</button>
                                        <button type="submit" name="Terminer" class="btn btn-default">Envoyer a SAAT</button>

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

<script type="text/javascript">
   function getBeneficiaire(va){
     var id_affilier= $(va).val();

      $.get('{{ route('getProduiBenfic') }}',
          {id_affilier:id_affilier},
          function(data){
            $('#AyantDroits').html(data);
          });
   }

   function research(va){
     var medicament= $(va).val();
     // var id_categorie= $("#Categorie").val();
      $.get('{{ route('researchmedicament') }}',
          {medicament:medicament},
          function(data){
            $("#prodReas").css('display','block');
            $('#Produit').html(data);
          });
   }
</script>