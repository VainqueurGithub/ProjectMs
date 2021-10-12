@extends('layout.base', ['title' => 'Assurance - Journal Cotisation'])
@section('content')
 <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
                  <form method="POST" action="{{ route('PdfCreateCotisation')}}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-2">
                              <div class="form-group">
                                <label>Groupe</label>
                                  <select name="Groupe" class="form-control select2">
                                    <option></option>
                                  @foreach($Partenaires as $G)
                                    <option value="{{ $G->id}}"> {{ $G->Origine}}</option>
                                  @endforeach    
                                  </select>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                    <label>Individu</label>
                                   <select class="form-control select2" name="Individu">
                                    <option></option>
                                    @foreach($Affiliers as $Affilier)
                                        <option value="{{$Affilier->id}}">{{$Affilier->Code}} / {{$Affilier->Nom}} {{$Affilier->Prenom}}</option>
                                    @endforeach    
                                    </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-group">
                                 <label>Du :</label>
                                 <input type="date" class="form-control" name="Debut" required="required" />
                                 {!! $errors->first('Debut', '<span class="error">:message</span>') !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Au :</label>
                                <input type="date" class="form-control" name="Fin" required="required" />
                                {!! $errors->first('Fin', '<span class="error">:message</span>') !!}
                              </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                <label>Génerer PDF</label>
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
                <h3 class="card-title">Journal des Cotisations</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>ADHERANT</th>
                                            <th>JANVIER</th>
                                            <th>FEVRIER</th>
                                            <th>MARS</th>
                                            <th>AVRIL</th>
                                            <th>MAI</th>
                                            <th>JUIN</th>
                                            <th>JUILLET</th>
                                            <th>AOUT</th>
                                            <th>SEPTEMBRE</th>
                                            <th>OCTOBRE</th>
                                            <th>NOVEMBRE</th>
                                            <th>DECEMBRE</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
                                    </tbody>
                                    <tfoot>
                                      @foreach($Somme as $S)
                                        <tr>
                                            <th>{{ $S->AF}}</th>
                                            <th>{{ $S->AF}}</th>
                                            <th>{{ $S->J}}</th>
                                            <th>{{ $S->F}}</th>
                                            <th>{{ $S->M}}</th>
                                            <th>{{ $S->A}}</th>
                                            <th>{{ $S->Ma}}</th>
                                            <th>{{ $S->Ju}}</th>
                                          <th>{{ $S->Jui}}</th>
                                            <th>{{ $S->Ao}}</th>
                                            <th>{{ $S->S}}</th>
                                            <th>{{ $S->O}}</th>
                                            <th>{{ $S->N}}</th>
                                            <th>{{ $S->D}}</th>
                                            <th>{{ $S->ST}}</th>
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
        </section>
      </div>
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