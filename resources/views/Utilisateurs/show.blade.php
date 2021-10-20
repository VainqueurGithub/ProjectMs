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
        <div class="col-md-12">
            <div class="modal-body">
                <strong>Roles :</strong>
                  @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                      <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                  @endif


              <form method="POST" action="{{route('add_permission')}}" enctype="multipart/form-data" onsubmit='return confirm("Etez - vous sur de cette Operation ?")'>
                {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                        <input type="hidden" required="required" name="User" value="{{$user->id}}">
                           <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" checked="" name="checkedall" id="checkedall" value=""></th>
                                                <th>Autres permissions specifiques</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($Permissions as $Permission) 
                                               <tr>
                                                @if($Permission->permission_id==$Permission->id AND $Permission->model_id==$user->id)
                                                 <td><input type="checkbox" checked="" name="permission[]" value="{{ $Permission->id}}" class="compteChecked"></td>
                                                @else
                                                  <td><input type="checkbox" class="compteChecked" name="permission[]" value="{{ $Permission->id}}"></td>
                                                @endif 
                                                 <td>{{ $Permission->name}}</td>
                                               </tr>
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>

                      <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" name="ajouter" class="btn btn-success swalDefaultSuccess" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-plus"></i> Ajouter</button>

                           <button type="submit" name="supprimer" class="btn btn-danger swalDefaultDanger" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-trash"></i> Suprrimer</button>
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
