@extends('layout.base', ['title' => 'Assurance - Journal Cotisation'])

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
                 <hr/>
                  <form method="POST" action="{{ route('PdfCreateFactures')}}" target="blank">
                        {{ csrf_field() }}
                        <div class="row">
                            
                            <div class="col-md-2" >
                              <div class="form-group">
                                    <label>Affilier</label>
                                    <input type="text" name="prodReas" id="prodReas"  class="form-control" style="" oninput="research(this)">
                                   <select class="form-control" name="Individu" id="Produit">
                                        <option value="">-- Selectionner l'Affilier --</option>
                                    </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>


                             <div class="col-md-2" >
                              <div class="form-group">
                                    <label>Beneficiare</label>
                                    <input type="text" name="prodReas" id="prodReas"  class="form-control">
                                   <select class="form-control" name="Individu" id="Produit">
                                        <option value="">-- Selectionner l'Affilier --</option>
                                    </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>


                             <div class="col-md-2" >
                              <div class="form-group">
                                    <label>Partenaire</label>
                                    <input type="text" name="prodReas" id="prodReas"  class="form-control">
                                   <select class="form-control" name="Individu" id="Produit">
                                        <option value="">-- Selectionner l'Affilier --</option>
                                    </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>



                            <div class="col-md-2" >
                              <div class="form-group">
                                    <label>Date Traitement</label>
                                    <input type="date" name="prodReas" id="prodReas"  class="form-control">
                                </div>
                            </div>


                             <div class="col-md-2" >
                              <div class="form-group">
                                    <label>Date Transmission</label>
                                    <input type="date" name="prodReas" id="prodReas"  class="form-control">
                                  
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>
                    
                        
                            <div class="col-md-2" >
                              <div class="form-group">
                                    <label>Type de Traitement</label>
                                   <select class="form-control" name="Individu" id="Produit">
                                        <option value="">-- Selectionner l'Affilier --</option>
                                    </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>

                          
                            </div> <hr/>


                            <div class="row">
                            

                            <div class="col-md-3" >
                              <div class="form-group">
                                    <label>Service * </label>
                                   <select class="form-control" name="Individu" id="Produit">
                                        <option value="">-- Selectionner l'Affilier --</option>
                                    </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>


                             <div class="col-md-3" >
                              <div class="form-group">
                                    <label>Libelle</label>
                                    <input type="text" name="prodReas" id="prodReas"  class="form-control" style="" oninput="research(this)">
                                   <select class="form-control" name="Individu" id="Produit">
                                        <option value="">-- Selectionner l'Affilier --</option>
                                    </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>


                             <div class="col-md-3">
                              <div class="form-group">
                                    <label>Quantité</label>
                                    <input type="date" name="prodReas" id="prodReas"  class="form-control">
                                  
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>
                    
                        
                            <div class="col-md-3">
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
                            </div>

                          
                            </div>



                        </div>
                     </form>    
              

        </div>
               
    </div>
             <!-- /. PAGE INNER  -->
@endsection 


<script type="text/javascript">
    function research(va){
     var affilie= $(va).val();
     // var id_categorie= $("#Categorie").val();
      $.get('{{ route('researchAffilierCotisation') }}',
          {affilie:affilie},
          function(data){
            $("#prodReas").css('display','block');
            $('#Produit').html(data);
          });
   }
</script>