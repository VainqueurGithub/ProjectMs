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
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="modal-body">
              <form method="POST" action="{{route('attachedAccount')}}" enctype="multipart/form-data" onsubmit='return confirm("Etez - vous sur de cette Operation ?")'>
                {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                        <input type="hidden" required="required" name="CompteR" value="{{$CompteR}}">
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
                                          @foreach($ComptePrincipal as $CompteP) 
                                               <tr>
                                                @if($CompteP->compte_principale_id==$CompteP->id AND $CompteP->compte_repport_id==$CompteR AND $CompteP->etat==0)
                                                 <td><input type="checkbox" checked="" name="compte[]" value="{{ $CompteP->id}}" class="compteChecked"></td>
                                                @else
                                                  <td><input type="checkbox" class="compteChecked" name="compte[]" value="{{ $CompteP->id}}"></td>
                                                @endif 
                                                 <td>{{ $CompteP->NumeroCompte}}</td>
                                                 <td>{{ $CompteP->Intitule }}</td>
                                               </tr>
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>

                      <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success swalDefaultSuccess" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-save"></i> Valider L'action</button>
                        </div>
                      </div>

                    </div>
                  </div>

              </form>
            </div>
        </div>
        <!-- /.modal-dialog -->
        <div class="col-md-3"></div>
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
          </div>

                        @endsection

<script type="text/javascript">
   $(document).ready(function(){
    alert("Bon");
       $('#checkedall').click(function(){
            if($('#checkedall').checked==false){
               $('.compteChecked').prop("checked", true);
               $('#checkedall').prop("checked", true);
            }else{
                $('.compteChecked').prop("checked", false);
                $('#checkedall').prop("checked", false);
            }
       });
   });
</script>
