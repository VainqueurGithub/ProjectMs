 @extends('layout.base')
 @section('content')
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Permission</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                        <i class="ti-plus"></i> Nouvelle Permission
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
                 @foreach ($data as $key => $value)
                 <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>
                        @can('permission-edit')
                            <a href="{{ route('permissions.edit',$value->id) }}"><i class="fas fa-edit"></i></a>
                        @endcan

            @can('permission-delete')
                 <form action="{{ route('permissions.destroy', $value->id) }}" method="POST" style="display: inline-block;" onsubmit='return confirm("Etez -vous sur de cette Operation ?")'>
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
      <div class="modal fade none-border" id="add-new-event">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><strong>Ajouter une nouvelle permission</strong></h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
              <form method="POST" action="{{route('permissions.store')}}">

<div class="row">
   <div class="col-2"></div>
   <div class="col-md-8" style="padding: 10px;">
      <div class="form-group">
        <label>Permission *</label>
        <input class="form-control form-white" name="name" value="{{ old('name')}}"/>
        {!! $errors->first('name', '<span class="error">:message</span>') !!}
      </div>
      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
 </div>
</form>
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->



                 <!-- Modal Add Category -->
                </div>
                <!-- END MODAL -->
@endsection