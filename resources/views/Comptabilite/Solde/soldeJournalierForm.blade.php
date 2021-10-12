@extends('layout.base')
@section('content')                                              
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <section class="content">
      <div class="container-fluid">
            <div class="row">
                                         <div class="col-12">
              <form method="POST" action="{{route('SoldeJournalierAccount')}}" enctype="multipart/form-data" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                  <div class="card-body">
                    <div class="row">
                           <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" checked="" name="checkedall" id="checkedall" value=""></th>
                                                <th>Code</th>
                                                <th>Intitulé</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                          {{ csrf_field() }}
                                         
                                              @include('Comptabilite/Solde._Form')
  </tbody>
                                    </table>
                                </div>

                      <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success" name="Ajouter"><i class="fas fa-plus"></i> Ajouter</button>

                          <button type="submit" class="btn btn-danger" name="Supprimer"><i class="fas fa-trash"></i> Supprimer</button>
                        </div>
                      </div>

                    </div>
                  </div>

              </form>
           </div>
                                  </div>
                                </div>
                              </section>



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
          </div>

                        @endsection


<script type="text/javascript">
  function getRepportage(va){
    var repportage= $(va).val();
    $.get('{{route('getRepportageId')}}',
    {repportage:repportage},
    function(data){
      var donnee = data.split("#");
      $("#Identifiant").val(repportage);
      $("#Montant").val(donnee[0]);
      $("#Compte").html(donnee[1]);
    });
  }
</script>                        
