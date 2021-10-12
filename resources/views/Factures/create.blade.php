@extends('layout.base', ['title' => 'Assurance - Nouvelle Facture'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
        <h2 style="color: blue;font-weight: bold;text-align: center;">Nouvelle Facture</h2>
        </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Ajout d'une Facture
                             <a href="{{ route('Factures.index') }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-book"></i> Liste des Facture
                            </a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form role="form" method="POST" action="{{ route('Factures.store')}}">
                                      {{ csrf_field() }}
                                        <div class="form-group">
                                            <label>N° Facture</label>
                                            <input class="form-control" placeholder="N° Facture" name="Facture" value="{{ old('Facture') }}"/>

                                            {!! $errors->first('Facture', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Date Traitement</label>
                                            <input type="date" class="form-control" placeholder="Date Traitement" name="DateT" />

                                            {!! $errors->first('DateT', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Affilier</label>
                                            <select class="form-control" name="Affilier" id="Affilier" onclick="getBeneficiaire(this)">
                                              @foreach($Affiliers as $A)
                                               <option value="{{ $A->id}}">{{ $A->Code}}</option>
                                               @endforeach
                                            </select>
                                            {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Béficiaire</label>
                                            <select class="form-control" name="AyantDroits" id="AyantDroits">
                                              <option>Selectionner le beneficiare</option>
                                             
                                            </select>
                                            {!! $errors->first('AyantDroits', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Date Transmission</label>
                                            <input type="date" class="form-control" placeholder=" Date Transmission" name="DateTr" />

                                            {!! $errors->first('DateTr', '<span class="error">:message</span>') !!}
                                        </div>
                                      </div>

                                      <div class="col-md-6">
                                        <div>
                                    <label>Partenaire</label>
                                            <select class="form-control" name="Partenaire">
                                             <option></option> 
                                            @foreach($Partenaires as $P)
                                               <option value="{{ $P->id}}">{{ $P->Partenaire}}</option>
                                               @endforeach
                                            </select>
                                            {!! $errors->first('Partenaire', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Montant</label>
                                            <input type="number" min="1" class="form-control" placeholder="Montant de la Facture" name="Montant" value="{{ old('Montant') }}" />

                                            {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
                                        </div>
                                        <div class="form-group">
                                    <label>Date Payement</label>
                                            <input type="date" class="form-control" name="DatePay" placeholder="Date Payement"/>

                                            {!! $errors->first('DatePay', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Mode Payement</label>
                                            <input type="text" class="form-control" placeholder="Mode Payement" name="ModePay" value="{{ old('ModePay') }}" />

                                            {!! $errors->first('ModePay', '<span class="error">:message</span>') !!}
                                        </div>
                                       <label></label><br>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        <button type="reset" class="btn btn-default">Annuler</button>

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
</script>