@extends('layout.base')
@section('content')                        
                         <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
           
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                  <div class="row">

                                         <div class="col-12">
                                    <form method="POST" action=" {{route('Repportage.update', $Repportage->id)}}">  
                                          {{ csrf_field() }}
                                          {{ method_field('PUT') }}
                                          @include('Comptabilite/CompteRepport._Form', ['LibelleButton'=>'Modifier'])
                                           </form>  
                                        </div>
                                  </div><hr>

                                @include('Comptabilite/CompteRepport._Table')
                            </div>
                        </div>
                    </div>
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
      $.get('{{ route('researchComptesReported') }}',
          {NumeroCompte:NumeroCompte},
          function(data){
            $("#prodReas").css('display','block');
            $('#Produit').html(data);

          });
   }
</script>