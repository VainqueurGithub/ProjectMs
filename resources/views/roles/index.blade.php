 @extends('layout.base')
 @section('content')
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Roles</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                    <a href="{{route('roles.create')}}" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                        <i class="ti-plus"></i> Nouveau Role
                    </a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Nom</th>
                      <th>Action</th>
                    </tr>
                 </thead> 
                 <tbody>
                 @foreach ($roles as $key => $role)
                 <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @can('role-edit')
                            <a href="{{ route('roles.edit',$role->id) }}"><i class="fas fa-edit"></i></a>
                        @endcan

            @can('role-delete')
                 <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline-block;" onsubmit='return confirm("Etez -vous sur de cette Operation ?")'>
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                    
                                <button style="border: none;" class="btn btn-danger btn-sm" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-trash"></i>
                                </button>
                               </form>
            @endcan
        </td>
    </tr>
    @endforeach
   </tbody>
 </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </section>
      </div>
             <!-- /. PAGE INNER  -->



                 <!-- Modal Add Category -->
                </div>
                <!-- END MODAL -->
@endsection