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
                                          <form method="POST" action=" {{route('Repportage.store')}}" name="P_form">  
                                          {{ csrf_field() }}
                                         
                                              @include('Comptabilite/CompteRepport._Form', ['LibelleButton'=>'Enregistrer'])
                                              
                                           </form>  
                                        </div>
                                  </div><hr>
                                 

                                 @include('Comptabilite/CompteRepport._Table')


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->

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
