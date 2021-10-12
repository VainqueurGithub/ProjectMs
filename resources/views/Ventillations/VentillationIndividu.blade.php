@extends('layout.base', ['title' => 'Assurance - Ventillation Par Individu'])
@section('content')
 <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
                     <form method="POST" action="{{ route('PdfCreateIndividu')}}">
                        {{ csrf_field() }}
                        <div class="row" style="width:100%;">
                            <div class="col-md-4">
                               <div class="form-group">
                                    <label>Individu</label>
                                   <select class="form-control select2" name="Individu" id="Produit" required="required">
                                    @foreach($Affiliers as $Affilier)
                                        <option value="{{$Affilier->id}}">{{$Affilier->Code}} / {{$Affilier->Nom}} {{$Affilier->Prenom}}</option>
                                    @endforeach    
                                    </select>
                                    {!! $errors->first('Individu', '<span class="error">:message</span>') !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                 <label>Du :</label>
                                 <input type="date" class="form-control" name="Debut" required="required" />
                                </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Au :</label>
                                <input type="date" class="form-control" name="Fin" required="required" />
                              </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                <label style="">Génerer PDF</label>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Rechercher</button>
                                </div> 
                            </div>
                        </div>
                     </form> 
                  </div>
    </section><hr />

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">VENTILLATION PAR GROUPE</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-striped">
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
                </div>
            </div>
           </div>
        </section>
      </div>
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