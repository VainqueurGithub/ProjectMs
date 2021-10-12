@extends('layout.base')
@section('content')                        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                              <div class="row">

                                <div class="col-8">
                                    <form method="GET" action=" {{route('AfficherGdLivre')}}">  
                                          {{ csrf_field() }}
                                          <div class="row">

                                             <div class="col-6">
                                                  <div class="form-group">
                                                    <select class="form-control select2" data-control="hue" name="Exercice" required="">
                                                      @foreach($Exercices as $Exercice)
                                                       <option value="{{ $Exercice->id }}">{{ $Exercice->Debut }} - {{ $Exercice->Fin }}</option>
                                                      @endforeach 
                                                    </select>
                                                 </div> 
                                              </div>

                                              <div class="col-5">
                                                  <button type="submit" class="btn btn-success" name="Rapport">Afficher GD</button>
                                              </div>
                                           
                                          </div>
                                           </form>  
                                        </div>
                                  </div><hr>

                                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Libellé</th>
                                                <th>Débit</th>
                                                <th>Crédit</th>
                                            </tr>
                                        </thead>
                                       
                                            {!! $tableListe !!}
                                       
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
              </div>
                                        </div>
                                        </div>
            </div>
       </div>
      </div><!-- /.container-fluid -->
    </section>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->

                        @endsection
<script type="text/javascript">
  function research(va){
     var NumeroCompte= $(va).val();
     // var id_categorie= $("#Categorie").val();
      $.get('{{ route('researchSousComptes') }}',
          {NumeroCompte:NumeroCompte},
          function(data){
            $("#prodReas").css('display','block');
            $('#Produit').html(data);
          });
   }

</script> 

<script type="text/javascript">
  function research1(va){
     var NumeroCompte= $(va).val();
     // var id_categorie= $("#Categorie").val();
      $.get('{{ route('researchSousComptes') }}',
          {NumeroCompte:NumeroCompte},
          function(data){
            $("#prodReas1").css('display','block');
            $('#Produit1').html(data);
          });
   }

</script>                                         