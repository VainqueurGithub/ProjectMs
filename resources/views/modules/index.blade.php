@extends('layout.base', ['title' => 'Assurance - Modules'])
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">MS</a></li>
              <li class="breadcrumb-item active">Modules</li>
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
                <h3 class="card-title">Liste des Modules</h3>
                <div class="row">
                  <div class="col-md-8"></div>
                  <div class="col-md-4">
                     <div class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-sm"  style="margin-top: -5px">
                      <i class="fa fa-plus"></i> Ajouter un Module
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                          <th>Module</th>
                                          <th>Statut</th>
                                          <th>Permission</th>
                                          <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($modules as $module)

                                         <tr class="odd gradeX">
                                            <td>{{ $module->module }}</td>
                                            @if($module->etat==0)
                                            <td>Actif</td>
                                            @else
                                             <td>Inactif</td>
                                            @endif
                                            <td>
                                              <button style="border: none;cursor: pointer;" value="{{$module->id}}" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopup(this); return false;">
                                                <span class="badge badge-light">{{$module->NPerm}}</span><i class="fas fa-plus"></i>
                                              </button>
                                            </td>  
                                  <td>          
                                <a href="{{ route('module.edit', $module->id) }}"><i class="fas fa-edit"></i></a>

                                <form action="{{ route('module.destroy', $module->id) }}" method="POST" style="display: inline-block;" onsubmit='return confirm("Etez -vous sur de cette Operation ?")'>
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                    
                                <button style="border: none;" class="btn btn-danger btn-sm" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-trash"></i>
                                </button>
                               </form>

                                <a href="{{ route('module.show', $module->id)}}"><i class="fas fa-print"></i></a>
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
              <h4 class="modal-title">Nouveau Module</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" method="POST" action="{{ route('module.store')}}">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Module *</label>
                    <input class="form-control" name="Module" value="{{ old('Module') ?: $mod->module }}"/> {!! $errors->first('Module', '<span class="error">:message</span>') !!}
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
     var url = "{{ route('module.show', ":id") }}";
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