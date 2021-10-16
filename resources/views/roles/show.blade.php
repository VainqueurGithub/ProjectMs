@extends('layout.base')
@section('content')                        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <form method="POST" action="{{route('add_permission')}}" enctype="multipart/form-data" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'>
                {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                        <input type="hidden" required="required" name="role" value="{{$id}}">
                           <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" checked="" name="checkedall" id="checkedall" value=""></th>
                                                <th>Module</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($Permissions as $Permission) 
                                               <tr>
                                               
                                                 <td><input type="checkbox" checked="" name="permission[]" value="{{$Permission->id}}" class="compteChecked"></td>
                                        
                                                 <td>{{$Permission->module}}</td>
                                                 <td>{{$Permission->action}}</td>
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
