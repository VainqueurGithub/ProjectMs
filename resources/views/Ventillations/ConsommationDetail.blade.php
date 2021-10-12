@extends('layout.base', ['title' => 'Assurance - Ventillation Par Individu'])

@section('content')
              <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-5">
                    <h2 style="color: blue;font-weight: bold;text-align: center;">CONSOMMATION DETAILLEE</h2>   
                  </div>
                  <div class="col-md-7">
                     <form method="POST" action="{{ route('PdfViewDetails')}}">
                        {{ csrf_field() }}
                        <div class="row" style="width:100%;">
                            <div class="col-md-4">
                               <div class="form-group">
                                    <label>Individu</label>
                                    <input type="text" name="prodReas" id="prodReas"  class="form-control" style="" oninput="research(this)">
                                   <select class="form-control" name="Individu" id="Produit" required="required">
                                        <option value="">-- Selectionner l'Affilier --</option>
                                    </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                 <label>Du :</label>
                                 <input type="date" class="form-control" name="Debut"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Au :</label>
                                <input type="date" class="form-control" name="Fin"/>
                              </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                <label style="visibility: hidden;">Rech</label>
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                                </div> 
                            </div>
                        </div>
                     </form> 
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>ADHERANT</th>
                                            <th>JAN.</th>
                                            <th>FEV.</th>
                                            <th>MARS</th>
                                            <th>AVRIL</th>
                                            <th>MAI</th>
                                            <th>JUIN</th>
                                            <th>JUILLE</th>
                                            <th>AOUT</th>
                                            <th>SEPT.</th>
                                            <th>OCTO.</th>
                                            <th>NOV.</th>
                                            <th>DEC.</th>
                                            <th>T.COT</th>
                                            <th>T.FACT</th>
                                            <th>ECART</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
                                       
                                    </tbody>
                                    <tfoot>
                                        @foreach($Somme as $S)
                                        <tr>
                                           <th>{{ $NbreAff }}</th>
                                           <th></th>
                                            <th>{{ $S->J }}</th>
                                            <th>{{ $S->F }}</th>
                                            <th>{{ $S->M }}</th>
                                            <th>{{ $S->A }}</th>
                                            <th>{{ $S->Ma }}</th>
                                            <th>{{ $S->Ju }}</th>
                                            <th>{{ $S->Jui }}</th>
                                            <th>{{ $S->Ao }}</th>
                                            <th>{{ $S->S }}</th>
                                            <th>{{ $S->O }}</th>
                                            <th>{{ $S->N }}</th>
                                            <th>{{ $S->D }}</th>
                                            <th>{{ $TCot }}</th>
                                            <th>{{ $S->ST }}</th>
                                            <th>{{ $EcartT }}</th>
                                       </tr>
                                       @endforeach
                                    </tfoot>
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

<script type="text/javascript">
  function research(va){
     var affilie= $(va).val();
     // var id_categorie= $("#Categorie").val();
      $.get('{{ route('researchVentillationIndiv') }}',
          {affilie:affilie},
          function(data){
            $("#prodReas").css('display','block');
            $('#Produit').html(data);
          });
   }

</script>   