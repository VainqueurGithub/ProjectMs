@extends('layout.base', ['title' => 'Assurance - Journal Cotisation'])
@section('content')
      <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
          <form method="POST" action="{{ route('PdfCreateFactures')}}" target="blank">
                        {{ csrf_field() }}
        <div class="row mb-2">
                             @if(session()->get('Profil')=='Partenaire')
                            <div class="col-md-2" style='display:none'>
                              <div class="form-group">
                                <label>Partenaire</label>
                                  <select name="Partenaire" class="form-control select2">
                                    <option value="{{session()->get('id')}}">{{session()->get('id')}}</option>
                                  </select>
                              </div>
                            </div>
                         @else
                         <div class="col-md-2">
                              <div class="form-group">
                                <label>Partenaire</label>
                                  <select name="Partenaire" class="form-control select2">
                                    <option></option>
                                  @foreach($Partenaires as $P)
                                    <option value="{{ $P->id}}"> {{ $P->Partenaire}}</option>
                                  @endforeach    
                                  </select>
                              </div>
                            </div>
                         @endif   
                          @if(session()->get('Profil')!='Partenaire')
                            <div class="col-md-2">
                              <div class="form-group">
                                <label>Groupe</label>
                                  <select name="Groupe" class="form-control select2">
                                    <option></option>
                                  @foreach($Origines as $G)
                                    <option value="{{ $G->id}}"> {{ $G->Origine}}</option>
                                  @endforeach    
                                  </select>
                              </div>
                            </div>
                          @endif
                            <div class="col-md-2">
                               <div class="form-group">
                                    <label>Individu</label>
                                    <select class="form-control select2" name="Individu" id="Produit">
                                       <option></option>
                                        @foreach($Affiliers as $F)
                                          <option value="{{ $F->id}}"> {{ $F->Nom}} {{ $F->Prenom}}</option>
                                        @endforeach   
                                    </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                                

                            </div>

                            <div class="col-md-2">
                              <div class="form-group">
                                 <label>Du :</label>
                                 <input type="date" class="form-control" required="" name="Debut"/>
                                </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-group">
                                <label>Au :</label>
                                <input type="date" class="form-control" required="" name="Fin"/>
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
      </div><!-- /.container-fluid -->
    </section><hr />
     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Journal des Factures</h3>
              </div>
              <!-- /.card-header -->
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
                                            <th><?php echo number_format($S->J,0,',',' ')?></th>
                                            <th><?php echo number_format($S->F,0,',',' ')?></th>
                                            <th><?php echo number_format($S->M,0,',',' ')?></th>
                                            <th><?php echo number_format($S->A,0,',',' ')?></th>
                                            <th><?php echo number_format($S->Ma,0,',',' ')?></th>
                                            <th><?php echo number_format($S->Ju,0,',',' ')?></th>
                                            <th><?php echo number_format($S->Jui,0,',',' ')?></th>
                                            <th><?php echo number_format($S->Ao,0,',',' ')?></th>
                                            <th><?php echo number_format($S->S,0,',',' ')?></th>
                                            <th><?php echo number_format($S->O,0,',',' ')?></th>
                                            <th><?php echo number_format($S->N,0,',',' ')?></th>
                                            <th><?php echo number_format($S->D,0,',',' ')?></th>
                                            <th><?php echo number_format($S->ST,0,',',' ')?></th>
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