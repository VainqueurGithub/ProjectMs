@extends('layout.base')
@section('content')                        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <section class="content">
      <div class="container-fluid">
                                  <div class="row">
                                         <div class="col-12">
              <form method="POST" action="{{route('attachedJournal')}}" enctype="multipart/form-data" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'>
                {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                        <input type="hidden" required="required" name="Journal" value="{{$Journal}}">
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
                                                @if($CompteP->Compte==$CompteP->id AND $CompteP->Journal==$Journal AND $CompteP->Etat==0)
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
                          <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Ajouter</button>
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
