@extends('layout.base', ['title' => 'Assurance - Roles'])
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">MS</a></li>
              <li class="breadcrumb-item active">Roles</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Roles</h3>
                <div class="row">
                  <div class="col-md-8"></div>
                  <div class="col-md-4">
                     <div class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-sm"  style="margin-top: -5px">
                      <i class="fa fa-plus"></i> Ajouter un Role
                    
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                          <th>Role</th>
                                          <th>Statut</th>
                                          <th>Permissions</th>
                                          <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($roles as $role)

                                         <tr class="odd gradeX">
                                            <td>{{ $role->role }}</td>
                                            @if($role->etat==0)
                                            <td>Operationnel</td>
                                            @else
                                             <td>Suspendu</td>
                                            @endif
                                            <td>
                                              <button style="border: none;cursor: pointer;" value="{{$role->id}}" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopup(this); return false;">
                                                <span class="badge badge-light"></span><i class="fas fa-plus"></i>
                                              </button>
                                            </td>  
                                  <td>          
                                <a href="{{ route('role.edit', $role->id) }}"><i class="fas fa-edit"></i></a>

                                <form action="{{ route('role.destroy', $role->id) }}" method="POST" style="display: inline-block;" onsubmit='return confirm("Etez -vous sur de cette Operation ?")'>
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                    
                                <button style="border: none;" class="btn btn-danger btn-sm" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-trash"></i>
                                </button>
                               </form>

                                <a href="{{ route('role.show', $role->id)}}"><i class="fas fa-print"></i></a>
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


      <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Nouveau Role</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" method="POST" action="{{ route('role.store')}}">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Role *</label>
                    <input class="form-control" name="Role" value="{{ old('Role') ?: $rol->role }}"/> {!! $errors->first('Role', '<span class="error">:message</span>') !!}
                </div>                       
              <label></label><br>
               <button type="submit" class="btn btn-primary">Ajouter</button>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

@endsection 
<script type="text/javascript">
   var WindowObjectReference = null; // variable globale
function openFFPromotionPopup(va) {
     var id = $(va).val();
     var url = "{{ route('role.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "toolbar=no,scrollbars=no,location=no,statusbar=no,width=940,height=500,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}
</script>